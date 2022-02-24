<?php

namespace App\Controllers\Payment;

use App\Controllers\Controller;
use App\Models\ShopOrder;
use App\Models\User;
use App\Utils\ConsoleManager;
use App\Utils\PaymentManager;
use Exception;
use Illuminate\Database\Capsule\Manager;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Rest\ApiContext;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Validator\Validator;

class PaypalController extends Controller
{
    public function postGetUrl(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->container->get(Manager::class);
        $apiContext = $this->container->get(ApiContext::class);

        $validator = new Validator($request->getParsedBody());
        $validator->required('items', 'shipping_method', 'order_note');
        $validator->notEmpty('items', 'shipping_method');
        if ($validator->isValid()) {
            /** @var $user User */
            $user = User::query()->find($this->session()->getUser()['id']);
            $paymentManager = new PaymentManager(
                $validator->getValue('items'),
                $user->getAddressObject(),
                $validator->getValue('shipping_method'),
                $this->container
            );

            if (!$paymentManager->isValid()) {
                return $response->withJson([
                    'success' => false,
                    'errors' => [['message' => 'Invalid inputs']]
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
            } catch (Exception $e) {
                return $response->withJson([
                    'success' => false,
                    'errors' => [[$e->getMessage(), $e->getCode()]]
                ], 500);
            }

            // before creating a new order, we will delete all the non payed order of the user
            PaymentManager::destroyNotPayedOrder($user);

            // save the payment in a database
            $order = $paymentManager->toShopOrder();
            $order->user()->associate($user);
            $order['shipping_address'] = json_encode($user->getAddressObject());
            $order['shipping_method'] = $validator->getValue('shipping_method');
            $order['on_way_id'] = $_payment->getId();
            $order['way'] = 'paypal';
            $order['note'] = $validator->getValue('order_note');
            $order->save();

            $redirectTo = $payment->getApprovalLink();

            return $response->withJson([
                'success' => true,
                'data' => ['url' => $redirectTo]
            ]);
        } else {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ], 400);
        }
    }

    public function postExecute(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->container->get(Manager::class);
        $apiContext = $this->container->get(ApiContext::class);

        $validator = new Validator($request->getParsedBody());
        $validator->required('token', 'payment_id', 'payer_id');
        $validator->notEmpty('token', 'payment_id', 'payer_id');
        if (!$validator->isValid())
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ], 400);
        try {
            $payment = Payment::get($validator->getValue('payment_id'), $apiContext);
        } catch (Exception $e) {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    ['message' => 'Invalid order']
                ]
            ], 400);
        }

        // get the item from the database
        /* @var $order ShopOrder */
        $order = ShopOrder::query()
            ->with('items', 'user')
            ->where('on_way_id', '=', $payment->getId())
            ->where('way', '=', 'paypal')
            ->first();

        if ($order == NULL)
            return $response->withJson([
                'success' => false,
                'errors' => [
                    ['message' => 'Invalid order']
                ]
            ], 400);

        if ($order['status'] == "payed")
            return $response->withJson([
                'success' => false,
                'errors' => [
                    ['message' => 'Order already payed']
                ]
            ], 400);

        /* @var $user User */
        $user = $order->user()->first();
        $paymentManager = new PaymentManager(
            $order['items']->toArray(),
            $user->getAddressObject(),
            $order['shipping_method'],
            $this->container
        );
        $execution = (new PaymentExecution())
            ->setPayerId($validator->getValue('payer_id'))
            ->addTransaction($paymentManager->toPaypalTransaction());

        try {
            $successPayment = $payment->execute($execution, $apiContext);
        } catch (Exception $e) {
            return $response->withJson([
                'success' => false,
                'errors' => [[$e->getMessage(), $e->getCode()]]
            ], 500);
        }

        if ($successPayment->getState() !== 'approved')
            return $response->withJson([
                'success' => false,
                'errors' => [
                    ['message' => 'Error with your paypal payment: the payment has failed or is not approved']
                ]
            ], 400);

        ConsoleManager::createConsolesFromOrder($this->container, $order);

        // we have a successful payment so we change the state in db
        $order['status'] = 'payed';
        $order->save();

        // emit "order.payed" event
        $this->jobatator()->publish('order.payed', ['id' => $order['id']]);

        return $response->withJson([
            'success' => true
        ]);
    }
}
