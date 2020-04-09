<?php

namespace App\Controllers\Payment;

use App\Auth\Session;
use App\Controllers\Controller;
use App\Models\ShopOrder;
use App\Models\User;
use App\Utils\ConsoleManager;
use App\Utils\PaymentManager;
use Illuminate\Database\Capsule\Manager;
use Lefuturiste\RabbitMQPublisher\Client;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Stripe\Charge;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Validator\Validator;

class StripeController extends Controller
{

    /**
     * Create a stripe checkout session
     *
     * @param ServerRequestInterface $request
     * @param Response $response
     * @param Session $session
     * @return Response
     */
    public function postCreateSession(ServerRequestInterface $request, Response $response, Session $session)
    {
        $this->container->get(Manager::class);
        $validator = new Validator($request->getParsedBody());
        $validator->required('items', 'shipping_method', 'shipping_country', 'order_note');
        $validator->notEmpty('items', 'shipping_method', 'shipping_country');

        Stripe::setApiKey($this->container->get('stripe')['private']);
        if (!$validator->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ])->withStatus(400);
        }
        $paymentManager = new PaymentManager(
            $validator->getValue('items'),
            $validator->getValue('shipping_country'),
            $validator->getValue('shipping_method'),
            $this->container
        );
        if (!$paymentManager->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    'Invalid inputs'
                ]
            ], 400);
        }
        try {
            $stripeSession = \Stripe\Checkout\Session::create(array_merge(
                $paymentManager->toStripeSession(),
                [
                    'payment_method_types' => ['card'],
                    'success_url' => $this->container->get('stripe')['return_redirect_url'],
                    'cancel_url' => $this->container->get('stripe')['cancel_redirect_url'],
                ]
            ));
        } catch (ApiErrorException $e) {
            return $response->withJson([
                'success' => false,
                'error' => [
                    'code' => $e->getCode(),
                    'error' => $e->getError()->toArray(),
                    'message' => $e->getMessage(),
                    'body' => $e->getHttpBody()
                ]
            ], 400);
        }
        return $response->withJson([
            'success' => true,
            'data' => [
                'stripe_session' => [
                    'id' => $stripeSession->id,
                    'data' => $stripeSession->toArray()
                ]
            ]
        ]);
    }

    public function postExecute(ServerRequestInterface $request, Response $response, Session $session, Client $rabbitMQPublisher)
    {
        $this->container->get(Manager::class);
        $validator = new Validator($request->getParsedBody());
        $validator->required('token', 'items', 'email', 'shipping_country', 'shipping_method', 'order_note');
        $validator->notEmpty('token', 'items', 'email', 'shipping_country', 'shipping_method');
        $validator->email('email');
        if ($validator->isValid()) {
            $paymentManager = new PaymentManager(
                $validator->getValue('items'),
                $validator->getValue('shipping_country'),
                $validator->getValue('shipping_method'),
                $this->container
            );

            if (!$paymentManager->isValid()) {
                return $response->withJson([
                    'success' => false,
                    'errors' => [
                        'Invalid inputs'
                    ]
                ], 400);
            }

            Stripe::setApiKey($this->container->get('stripe')['private']);
            try {
                $charge = Charge::create([
                    'amount' => $paymentManager->getTotalPrice() * 100,
                    'currency' => 'EUR',
                    'source' => $validator->getValue('token')
                ]);
            } catch (\Exception $exception) {
                return $response->withJson([
                    'success' => false,
                    'errors' => [
                        $exception->getMessage()
                    ]
                ])->withStatus(400);
            }
            $charge->getLastResponse();
            //success
            //create the payment in db
            $user = User::query()->find($session->getUser()['id']);
            $orderId = uniqid();
            $body = json_decode($charge->getLastResponse()->body, 1);
            $order = new ShopOrder();
            $order->id = $orderId;
            $order->user()->associate($user);
            $order->total_price = $paymentManager->getTotalPrice();
            $order->sub_total_price = $paymentManager->getSubTotalPrice();
            $order->total_shipping_price = $paymentManager->getTotalShippingPrice();
            $order->shipping_country = $validator->getValue('shipping_country');
            $order->shipping_method = $validator->getValue('shipping_method');
            $order->on_way_id = $body['id'];
            $order->way = "stripe";
            $order->status = "payed";
            $order->note = $validator->getValue('order_note');
            $order->items()->saveMany($paymentManager->getModels(), $paymentManager->getPivotsAttributes());
            $order->save();

            //save the user email
            $user->last_email = $validator->getValue('email');
            $user->save();

            //emit "order.payed" event
            $rabbitMQPublisher->publish(['id' => $orderId], 'order.payed');

            $resultConsoleCreation = ConsoleManager::createConsolesFromOrder($order);

            return $response->withJson([
                'success' => true,
                'console_creation' => $resultConsoleCreation
            ]);
        } else {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ])->withStatus(400);
        }

    }
}
