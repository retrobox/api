<?php

namespace App\Controllers\Payment;

use App\Auth\Session;
use App\Controllers\Controller;
use App\Models\ShopOrder;
use App\Models\User;
use App\PaymentManager;
use Illuminate\Database\Capsule\Manager;
use PayPal\Rest\ApiContext;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Validator\Validator;
use Lefuturiste\RabbitMQPublisher\Client;

class PaypalController extends Controller
{
    public function postGetUrl(ServerRequestInterface $request, Response $response, ApiContext $apiContext, Session $session)
    {
        $this->container->get(Manager::class);

        $validator = new Validator($request->getParsedBody());
        $validator->required('items', 'shipping_method', 'shipping_country');
        $validator->notEmpty('items', 'shipping_method', 'shipping_country');
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

            $transaction = $paymentManager->toPaypalTransaction();

            $payment = new \PayPal\Api\Payment();
            $payment->addTransaction($transaction);
            $payment->setIntent('sale');

            $redirectUrls = (new \PayPal\Api\RedirectUrls())
                ->setReturnUrl($this->container->get('paypal')['return_redirect_url'])
                ->setCancelUrl($this->container->get('paypal')['cancel_redirect_url']);
            $payment->setRedirectUrls($redirectUrls);
            $payment->setPayer((new \PayPal\Api\Payer())->setPaymentMethod('paypal'));

            try {
                $_payment = $payment->create($apiContext);
            } catch (\Exception $e) {
                return $response->withJson([
                    'success' => false,
                    'errors' => [
                        [
                            $e->getMessage(),
                            $e->getCode()
                        ]
                    ]
                ])->withStatus(500);
            }
            $user = User::query()->find($session->getUser()['id']);

            // before creating a new order, we will delete all the non payed order of the user
            $notPayedOrders = $user->shopOrders()
                ->where('status', '=', 'not-payed')
                ->get();
            ShopOrder::destroy(array_map(function ($order) {
                return $order['id'];
            }, $notPayedOrders->toArray()));

            //save the payment in a database
            $order = new ShopOrder();
            $order->id = uniqid();
            $order->user()->associate($user);
            $order->total_price = $paymentManager->getTotalPrice();
            $order->sub_total_price = $paymentManager->getSubTotalPrice();
            $order->total_shipping_price = $paymentManager->getTotalShippingPrice();
            $order->shipping_country = $validator->getValue('shipping_country');
            $order->shipping_method = $validator->getValue('shipping_method');
            $order->on_way_id = $_payment->getId();
            $order->way = "paypal";
            $order->status = "not-payed";
            $order->items()->saveMany($paymentManager->getModels(), $paymentManager->getPivotsAttributes());
            $order->save();

            $redirectTo = $payment->getApprovalLink();

            return $response->withJson([
                'success' => true,
                'data' => [
                    'url' => $redirectTo
                ]
            ]);
        } else {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ])->withStatus(400);
        }
    }

    public function postExecute(ServerRequestInterface $request, Response $response, ApiContext $apiContext, Client $rabbitMQPublisher)
    {
        $this->container->get(Manager::class);

        $validator = new Validator($request->getQueryParams());
        $validator->required('token', 'paymentId', 'PayerID');
        $validator->notEmpty('token', 'paymentId', 'PayerID');
        if ($validator->isValid()) {
            try {
                $payment = \PayPal\Api\Payment::get($validator->getValue('paymentId'), $apiContext);
            } catch (\Exception $e) {
                return $response->withJson([
                    'success' => false,
                    'errors' => [
                        "Invalid order"
                    ]
                ])->withStatus(400);
            }

            //get the item from the database
            $order = ShopOrder::query()
                ->with('items', 'user')
                ->where('on_way_id', '=', $payment->getId())
                ->where('way', '=', 'paypal')
                ->first();

            if ($order == NULL) {
                return $response->withJson([
                    'success' => false,
                    'errors' => [
                        "Invalid order"
                    ]
                ])->withStatus(400);
            }
            if ($order['status'] == "payed") {
                return $response->withJson([
                    'success' => false,
                    'errors' => [
                        "Order already payed"
                    ]
                ])->withStatus(400);
            }

            $paymentManager = new PaymentManager(
                $order->items->toArray(),
                $order->shipping_country,
                $order->shipping_method,
                $this->container
            );
            $execution = (new \PayPal\Api\PaymentExecution())
                ->setPayerId($validator->getValue('PayerID'))
                ->addTransaction($paymentManager->toPaypalTransaction());

            try {
                $successPayment = $payment->execute($execution, $apiContext);
            } catch (\Exception $e) {
                return $response->withJson([
                    'success' => false,
                    'errors' => [
                        [
                            $e->getMessage(),
                            $e->getCode()
                        ]
                    ]
                ])->withStatus(500);
            }

            if ($successPayment->getState() == 'approved') {
                //success
                //change the state in db
                $order->status = 'payed';
                $order->save();
                //change user's email in the db
                $user = $order->user()->first();
                $user['last_email'] = $payment->getPayer()->getPayerInfo()->getEmail();
                $user->save();
                //emit "order.payed" event
                $rabbitMQPublisher->publish(['id' => $order['id']], 'order.payed');
                //redirect to checkout success page
                return $this->redirect($response, $this->container->get('services')['web_endpoint'] . '/shop/checkout-success');
            } else {
                return $response->withJson([
                    'success' => false,
                    'errors' => [
                        "Error with your paypal payment: the payment has failed or is not approved"
                    ]
                ])->withStatus(400);
            }
        } else {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ])->withStatus(400);
        }
    }
}
