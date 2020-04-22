<?php

namespace App\Controllers\Payment;

use App\Auth\Session;
use App\Controllers\Controller;
use App\Models\ShopOrder;
use App\Models\User;
use App\Utils\ConsoleManager;
use App\Utils\PaymentManager;
use Illuminate\Database\Capsule\Manager;
use Lefuturiste\Jobatator\Client;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Rest\ApiContext;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Validator\Validator;

class PaypalController extends Controller
{
    public function postGetUrl(ServerRequestInterface $request, Response $response, ApiContext $apiContext, Session $session)
    {
        $this->container->get(Manager::class);

        $validator = new Validator($request->getParsedBody());
        $validator->required('items', 'shipping_method', 'shipping_country', 'order_note');
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

            $payment = new Payment();
            $payment->addTransaction($transaction);
            $payment->setIntent('sale');

            $redirectUrls = (new RedirectUrls())
                ->setReturnUrl($this->container->get('paypal')['return_redirect_url'])
                ->setCancelUrl($this->container->get('paypal')['cancel_redirect_url']);
            $payment->setRedirectUrls($redirectUrls);
            $payment->setPayer((new Payer())->setPaymentMethod('paypal'));

            try {
                $_payment = $payment->create($apiContext);
            } catch (\Exception $e) {
                return $response->withJson([
                    'success' => false,
                    'errors' => [[$e->getMessage(), $e->getCode()]]
                ])->withStatus(500);
            }
            /** @var $user User */
            $user = User::query()->find($session->getUser()['id']);

            // before creating a new order, we will delete all the non payed order of the user
            PaymentManager::destroyNotPayedOrder($user);

            // save the payment in a database
            $order = $paymentManager->toShopOrder();
            $order->user()->associate($user);
            $order['shipping_country'] = $validator->getValue('shipping_country');
            $order['shipping_method'] = $validator->getValue('shipping_method');
            $order['on_way_id'] = $_payment->getId();
            $order['way'] = 'paypal';
            $order['note'] = $validator->getValue('order_note');
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

    public function postExecute(ServerRequestInterface $request, Response $response, ApiContext $apiContext, Client $queue)
    {
        $this->container->get(Manager::class);

        $validator = new Validator($request->getQueryParams());
        $validator->required('token', 'paymentId', 'PayerID');
        $validator->notEmpty('token', 'paymentId', 'PayerID');
        if ($validator->isValid()) {
            try {
                $payment = Payment::get($validator->getValue('paymentId'), $apiContext);
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
            $execution = (new PaymentExecution())
                ->setPayerId($validator->getValue('PayerID'))
                ->addTransaction($paymentManager->toPaypalTransaction());

            try {
                $successPayment = $payment->execute($execution, $apiContext);
            } catch (\Exception $e) {
                return $response->withJson([
                    'success' => false,
                    'errors' => [[$e->getMessage(), $e->getCode()]]
                ])->withStatus(500);
            }

            if ($successPayment->getState() == 'approved') {
                // we have a successful payment
                // change the state in db
                $order->status = 'payed';
                $order->save();

                // emit "order.payed" event
                $queue->publish('order.payed', ['id' => $order['id']]);

                /** @var $order ShopOrder */
                ConsoleManager::createConsolesFromOrder($order);

                // redirect to checkout success page
                return $this->redirect($response, $this->container->get('services')['web_endpoint'] . '/shop/checkout/success');
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
