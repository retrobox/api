<?php

namespace App\Controllers;

use App\Colissimo\Client;
use App\Countries;
use App\Models\ShopCategory;
use App\Models\ShopItem;
use Illuminate\Database\Capsule\Manager;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Validator\Validator;

class ShopController extends Controller
{
    public function getCategories($locale, Response $response)
    {
        $this->container->get(Manager::class);
        if (array_search($locale, $this->container->get('locales')) !== false) {
            $categories = ShopCategory::with('items')
                ->where('locale', '=', $locale)
                ->orderBy('order', 'asc')
                ->get();
            return $response->withJson([
                'success' => true,
                'data' => [
                    'categories' => $categories->toArray()
                ]
            ]);
        } else {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    'Unknown locale slug'
                ]
            ])->withStatus(404);
        }
    }

    public function getItem($locale, $slug, Response $response)
    {
        $this->container->get(Manager::class);
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
            return $response->withJson([
                'success' => true,
                'data' => [
                    'item' => $render
                ]
            ]);
        }
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
        $validator->integer('weight');
        if (!$validator->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors(true)
            ], 400);
        }
        $weight = $validator->getValue('weight');
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
                'dhlPrice' => 0
            ]
        ]);
    }
}
