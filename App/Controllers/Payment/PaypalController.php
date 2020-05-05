<?php

namespace App\Controllers\Payment;

use App\Auth\Session;
use App\Controllers\Controller;
use App\Models\ShopOrder;
use App\Models\User;
use App\Utils\ConsoleManager;
use App\Utils\PaymentManager;
use Exception;
use Illuminate\Database\Capsule\Manager;
use Lefuturiste\Jobatator\Client;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Rest\ApiContext;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Validator\Validator;

class PaypalController extends Controller
{
    /**
     * @param ServerRequestInterface $request
     * @param Response $response
     * @param ApiContext $apiContext
     * @param Session $session
     * @return Response
     * @throws Exception
     */
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
                'data' => ['url' => $redirectTo]
            ]);
        } else {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ], 400);
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @param Response $response
     * @param ApiContext $apiContext
     * @param Client $queue
     * @return ResponseInterface|Response
     * @throws Exception
     */
    public function postExecute(ServerRequestInterface $request, Response $response, ApiContext $apiContext, Client $queue)
    {
        $this->container->get(Manager::class);

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

        //get the item from the database
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

        $paymentManager = new PaymentManager(
            $order->items->toArray(),
            $order->shipping_country,
            $order->shipping_method,
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

        /** @var $order ShopOrder */
        ConsoleManager::createConsolesFromOrder($this->container, $order);

        // we have a successful payment so we change the state in db
        $order->status = 'payed';
        $order->save();

        // emit "order.payed" event
        $queue->publish('order.payed', ['id' => $order['id']]);

        return $response->withJson([
            'success' => true
        ]);
    }
}
