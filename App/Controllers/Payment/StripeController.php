<?php

namespace App\Controllers\Payment;

use App\Auth\Session;
use App\Controllers\Controller;
use App\Models\ShopOrder;
use App\Models\User;
use App\PaymentManager;
use Illuminate\Database\Capsule\Manager;
use Lefuturiste\RabbitMQPublisher\Client;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Stripe\Charge;
use Stripe\Error\InvalidRequest;
use Stripe\Stripe;
use Validator\Validator;

class StripeController extends Controller
{
    public function postExecute(ServerRequestInterface $request, Response $response, Session $session, Client $rabbitMQPublisher)
    {
        $this->container->get(Manager::class);

        $validator = new Validator($request->getParsedBody());
        $validator->required('token', 'items');
        $validator->notEmpty('token', 'items');
        if ($validator->isValid()) {
            $paymentManager = new PaymentManager($validator->getValue('items'), $this->container);
            try {
                $total = $paymentManager->getTotalPrice();
            } catch (\Exception $exception){
                return $response->withJson([
                    'success' => false,
                    'errors' => [
                        'Invalid items'
                    ]
                ])->withStatus(400);
            }
            Stripe::setApiKey($this->container->get('stripe')['private']);
            try {
                $charge = Charge::create([
                    'amount' => $total * 100,
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
            $orderId = uniqid();
            $body = json_decode($charge->getLastResponse()->body, 1);
            $order = new ShopOrder();
            $order->id = $orderId;
            $order->user()->associate(User::query()->find($session->getUser()['id']));
            $order->total_price = $paymentManager->getTotalPrice();
            $order->sub_total_price = $paymentManager->getSubTotalPrice();
            $order->total_shipping_price = $paymentManager->getTotalShippingPrice();
            $order->on_way_id = $body['id'];
            $order->way = "stripe";
            $order->status = "payed";
            $order->items()->saveMany($paymentManager->getParsedItems());
            $order->save();

            //emit "order.payed" event
            $rabbitMQPublisher->publish(['id' => $orderId], 'order.payed');

            return $response->withJson([
                'success' => true
            ]);
        } else {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ])->withStatus(400);
        }

    }
}