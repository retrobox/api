<?php
namespace App\Controllers\Payment;

use App\Controllers\Controller;
use App\Models\ShopItem;
use Illuminate\Database\Capsule\Manager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Stripe\Charge;
use Stripe\Error\InvalidRequest;
use Stripe\Stripe;
use Validator\Validator;

class StripeController extends Controller {

    public function postExecute(ServerRequestInterface $request, ResponseInterface $response, Manager $manager){
        $validator = new Validator($request->getParsedBody());
        $validator->required('token', 'items');
        $validator->notEmpty('token', 'items');
        if ($validator->isValid()){
            $total = 0;
            //the items key contain the id of each item which you want to buy
            //verify in the db if this id exist and get the price of that
            //for now, all the transactions are in EUR
            foreach ($validator->getValue('items') as $itemId){
                $item = ShopItem::find($itemId);
                if ($item == NULL){
                    //no found
                    //stop here
                    return $response->withJson([
                        'success' => false,
                        'errors' => [
                            'Invalid items'
                        ]
                    ]);
                }
                $total = $total + $item['price'];
            }
            Stripe::setApiKey($this->container->get('stripe')['private']);
            try {
                $charge = Charge::create([
                    'amount' => $total * 100,
                    'currency' => 'EUR',
                    'source' => $validator->getValue('token')
                ]);
            }catch (InvalidRequest $invalidRequest){
                return $response->withJson([
                    'success' => false,
                    'errors' => [
                        $invalidRequest->getMessage()
                    ]
                ])->withStatus(400);
            }

//            di($charge->getLastResponse()); //get a Stripe\ApiResponse object
            $response->withJson([
                'success' => true
            ]);
        }else{
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ])->withStatus(400);
        }

    }
}