<?php

namespace App\Controllers\Payment;

use App\Auth\Session;
use App\Controllers\Controller;
use App\Models\ShopItem;
use App\Models\ShopPayment;
use App\Models\User;
use Illuminate\Database\Capsule\Manager;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Stripe\Charge;
use Stripe\Error\InvalidRequest;
use Stripe\Stripe;
use Validator\Validator;

class StripeController extends Controller
{
    public function postExecute(ServerRequestInterface $request, ResponseInterface $response, Manager $manager, Session $session)
    {
        $validator = new Validator($request->getParsedBody());
        $validator->required('token', 'items');
        $validator->notEmpty('token', 'items');
        if ($validator->isValid()) {
            $total = 0;
            //the items key contain the id of each item which you want to buy
            //verify in the db if this id exist and get the price of that
            //for now, all the transactions are in EUR
            $itemsModels = [];
            foreach ($validator->getValue('items') as $_item) {
                if (!isset($_item['id'])) {
                    return $response->withJson([
                        'success' => false,
                        'errors' => [
                            'Invalid items'
                        ]
                    ]);
                }
                $item = ShopItem::find($_item['id']);
                if ($item == NULL) {
                    //no found
                    //stop here
                    return $response->withJson([
                        'success' => false,
                        'errors' => [
                            'Invalid items'
                        ]
                    ]);
                }
                array_push($itemsModels, $item);
                //storage!!
                $bonus = 0;
                if (isset($_item['custom_options']['storage'])) {
                    switch ($_item['custom_options']['storage']) {
                        case 8:
                            $bonus = 0;
                            break;
                        case 16:
                            $bonus = 2.55;
                            break;
                        case 32:
                            $bonus = 3.55;
                            break;
                    }
                }
                $total = $total + $item['price'] + $bonus;
            }
            Stripe::setApiKey($this->container->get('stripe')['private']);
            try {
                $charge = Charge::create([
                    'amount' => $total * 100,
                    'currency' => 'EUR',
                    'source' => $validator->getValue('token')
                ]);
            } catch (InvalidRequest $invalidRequest) {
                return $response->withJson([
                    'success' => false,
                    'errors' => [
                        $invalidRequest->getMessage()
                    ]
                ])->withStatus(400);
            }
            $charge->getLastResponse();

//            di($charge->getLastResponse()); //get a Stripe\ApiResponse object
            //success
            //add a payment to rabbitmq queue
            //create the payment in db
            $orderId = uniqid();
            $body = json_decode($charge->getLastResponse()->body, 1);
            $pay = new ShopPayment();
            $pay->id = $orderId;
            $pay->user()->associate(User::find($session->getUser()['id']));
            $pay->total = $total;
            $pay->on_way_id = $body['id'];
            $pay->way = "stripe";
            $pay->status = $body['status'];
            $pay->items()->saveMany($itemsModels);
            $pay->save();
            $this->container->get(Logger::class)->info("NEW ORDER ! id: `{$orderId}` by `{$session->getUser()['id']} {$session->getUser()['email']}`");
            $response->withJson([
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