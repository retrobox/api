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
use Stripe\Stripe;
use Validator\Validator;

class StripeController extends Controller
{
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
