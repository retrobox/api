<?php

namespace App\Controllers\Payment;

use App\Controllers\Controller;
use App\Models\ShopOrder;
use App\Models\User;
use App\Utils\ConsoleManager;
use App\Utils\PaymentManager;
use Illuminate\Database\Capsule\Manager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as MessageResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\Webhook;
use UnexpectedValueException;
use Validator\Validator;

class StripeController extends Controller
{

    /**
     * Create a stripe checkout session
     */
    public function postCreateSession(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->container->get(Manager::class);
        $validator = new Validator($request->getParsedBody());
        $validator->required('items', 'shipping_method', 'order_note');
        $validator->notEmpty('items', 'shipping_method');

        Stripe::setApiKey($this->container->get('stripe')['private']);
        if (!$validator->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ], 400);
        }
        /** @var User $user */
        $user = User::query()->find($this->session()->getUserId());
        $paymentManager = new PaymentManager(
            $validator->getValue('items'),
            $user->getAddressObject(),
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
        PaymentManager::destroyNotPayedOrder($user);
        // create order entry from payment manager
        $order = $paymentManager->toShopOrder();
        $order['shipping_address'] = json_encode($user->getAddressObject());
        $order['shipping_method'] = $validator->getValue('shipping_method');
        $order['note'] = $validator->getValue('order_note');
        $order['way'] = 'stripe';
        $order->user()->associate($user);

        try {
            $stripeSession = \Stripe\Checkout\Session::create(array_merge(
                $paymentManager->toStripeSession(),
                [
                    'payment_method_types' => ['card'],
                    'success_url' => $this->container->get('stripe')['return_redirect_url'],
                    'cancel_url' => $this->container->get('stripe')['cancel_redirect_url'],
                    'metadata' => [
                        'user_id' => $this->session()->getUserId(),
                        'order_id' => $order['id'],
                        'total_price' => $order['total_price']
                    ]
                ],
                (
                    isset($this->session()->getUser()['email']) ?
                        ['customer_email' => $this->session()->getUser()['email']]
                    : []
                )
            ));
        } catch (ApiErrorException $e) {
            return $response->withJson([
                'success' => false,
                'errors' => [[
                    'code' => $e->getCode(),
                    'error' => $e->getError()->toArray(),
                    'message' => $e->getMessage(),
                    'body' => $e->getHttpBody()
                ]]
            ], 400);
        }

        $order['on_way_id'] = $stripeSession->id . '_intent_' . $stripeSession->payment_intent;
        $order->save();

        return $response->withJson([
            'success' => true,
            'data' => [
                'stripe_session' => [
                    'id' => $stripeSession->id,
                    'payment_intent' => $stripeSession->payment_intent,
                    'data' => $stripeSession->toArray()
                ],
                'order_id' => $order['id']
            ]
        ]);
    }

    public function postExecute(ServerRequestInterface $request, MessageResponseInterface $response)
    {
        $this->container->get(Manager::class);

        Stripe::setApiKey($this->container->get('stripe')['private']);
        $error = null;
        $errorDetails = null;
        $event = null;
        if (!$request->hasHeader('stripe-signature')) {
            return $response->withJson([
                'success' => false,
                'errors' => [['message' => 'Invalid headers, need stripe-signature header to be set']]
            ], 400);
        }
        try {
            $event = Webhook::constructEvent(
                $request->getBody()->getContents(),
                $request->getHeader('stripe-signature')[0],
                $this->container->get('stripe')['webhook_secret']
            );
        } catch (UnexpectedValueException $e) {
            $error = 'invalid-payload';
            $errorDetails = $e;
        } catch (SignatureVerificationException $e) {
            $error = 'invalid-signature';
            $errorDetails = $e;
        }
        if ($error !== null) {
            return $response->withJson([
                'success' => false,
                'errors' => [[
                    'name' => 'Stripe webhook error',
                    'key' => $error,
                    'code' => $errorDetails->getCode(),
                    'message' => $errorDetails->getMessage(),
                    'trace' => $errorDetails->getTraceAsString()
                ]],
            ], 400);
        }
        if ($event->type !== 'checkout.session.completed') {
            return $response->withJson([
                'success' => true,
                'notice' => 'This WebHook is only interested in checkout.session.completed event type. This endpoint is not very interested in other shitty types of WebHooks, thanks for your comprehension.'
            ]);
        }
        // if order not found throw error and return
        // check if order was already processed (so payed)
        // if order is already processed, throw error and return
        // process the order
        $onWayId = $event->data['object']['id'] . '_intent_' . $event->data['object']['payment_intent'];
        $order = ShopOrder::query()
            ->with('items', 'user')
            ->where('on_way_id', '=', $onWayId)
            ->where('way', '=', 'stripe')
            ->first();
        if ($order == NULL) {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    "Invalid order"
                ]
            ], 400);
        }
        if ($order['status'] == 'payed') {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    "Order already payed"
                ]
            ], 400);
        }

        /** @var $order ShopOrder */
        ConsoleManager::createConsolesFromOrder($this->container, $order);

        $order['status'] = 'payed';
        $order->save();

        $this->jobatator()->publish('order.payed', ['id' => $order['id']]);

        return $response->withJson([
            'success' => true,
            'notice' => 'Thanks you for this really cool event. This is very grateful from you. Love you!',
            'debug' => [
                'id' => $event->data['object']['id'],
                'payment_intent' => $event->data['object']['payment_intent'],
                'order_id' => $event->data['object']['metadata']['order_id'],
                'user_id' => $event->data['object']['metadata']['user_id'],
                'on_way_id' => $onWayId
            ]
        ], 201);
    }
}
