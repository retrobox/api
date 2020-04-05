<?php

namespace App\Controllers;

use App\Colissimo\Client;
use App\Models\ShopCategory;
use App\Models\ShopItem;
use App\Utils\Countries;
use Illuminate\Database\Capsule\Manager;
use Lefuturiste\LocalStorage\LocalStorage;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Validator\Validator;

class ShopController extends Controller
{
    public function getCategories($locale, Response $response, LocalStorage $localStorage)
    {
        if ($localStorage->exists("shop_categories_" . $locale)) {
            $categories = $localStorage->get("shop_categories_" . $locale);
        } else {
            $this->container->get(Manager::class);
            if (array_search($locale, $this->container->get('locales')) !== false) {
                $categories = ShopCategory::with('items')
                    ->where('locale', '=', $locale)
                    ->orderBy('order', 'asc')
                    ->get();
                $localStorage->set("shop_categories_" . $locale, $categories->toArray());
                $localStorage->save();
            } else {
                return $response->withJson([
                    'success' => false,
                    'errors' => [
                        'Unknown locale slug'
                    ]
                ])->withStatus(404);
            }
        }
        return $response->withJson([
            'success' => true,
            'data' => [
                'categories' => $categories
            ]
        ]);
    }

    public function getItem($locale, $slug, Response $response, LocalStorage $localStorage)
    {
        if ($localStorage->exists("shop_item_" . $locale . "_" . $slug)) {
            $render = $localStorage->get("shop_item_" . $locale . "_" . $slug);
        } else {
            $this->container->get(Manager::class);
            if (array_search($locale, $this->container->get('locales')) !== false) {
                $item = ShopItem::with('categoryWithItems', 'images')
                    ->where('slug', '=', $slug)
                    ->where('locale', '=', $locale)
                    ->first();
                if ($item == NULL) {
                    return $response->withJson([
                        'success' => false,
                        'errors' => [
                            'Unknown shop item'
                        ]
                    ])->withStatus(404);
                } else {
                    $render = $item->toArray();
                    $render['category'] = $render['category_with_items'];
                    unset($render['category_with_items']);

                    $localStorage->set("shop_item_" . $locale . "_" . $slug, $render);
                    $localStorage->save();
                }
            } else {
                return $response->withJson([
                    'success' => false,
                    'errors' => [
                        'Unknown locale slug'
                    ]
                ])->withStatus(404);
            }
        }
        return $response->withJson([
            'success' => true,
            'data' => [
                'item' => $render
            ]
        ]);
    }

    public function getStoragePrices(Response $response)
    {
        return $response->withJson([
            'success' => true,
            'data' => [
                'storage_prices' => $this->container->get('shop')['storage_prices']
            ]
        ]);
    }

    /**
     * Get the shipping prices of all the available shipping methods for a given weight and target country
     *
     * query params:
     * - weight, integer in SI grams
     * - country, string in ISO 3166-1 code
     *
     * @param ServerRequestInterface $request
     * @param Response $response
     * @return Response
     */
    public function getShippingPrices(ServerRequestInterface $request, Response $response)
    {
        $validator = new Validator($request->getQueryParams());
        $validator->required('weight', 'country');
        $validator->notEmpty('weight', 'country');
        //$validator->integer('weight');
        // Here we have an issue with the lefuturiste/validator library, because the value of weight can be sometime a float
        // the validator doesn't provide a float verification method, so we are kind of suck here...
        // we will use tmp a float type forcing to do the job
        if (!$validator->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors(true)
            ], 400);
        }
        $weight = (float) $validator->getValue('weight');
        $country = $validator->getValue('country');
        $countriesHelper = $this->container->get(Countries::class);
        if (!$countriesHelper->isCountryCodeValid($country)) {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    'Invalid country code'
                ]
            ]);
        }
        $colissimoPrice = $this->container->get(Client::class)->getPrice('fr', $country, $weight);

        return $response->withJson([
            'success' => true,
            'data' => [
                'colissimo' => $colissimoPrice,
                'chronopost' => 1.00
            ]
        ]);
    }
}
