<?php

namespace App\Controllers;

use App\Colissimo\Client;
use App\Utils\CacheManager;
use App\Utils\Countries;
use Illuminate\Database\Capsule\Manager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Validator\Validator;

class ShopController extends Controller
{
    public function getCategories($locale, Response $response, ContainerInterface $container)
    {
        $redis = $container->get(\Predis\Client::class);
        if ($redis->exists("shop_categories_" . $locale)) {
            $categories = json_decode($redis->get("shop_categories_" . $locale), true);
        } else {
            $this->container->get(Manager::class);
            if (array_search($locale, $this->container->get('locales')) !== false) {
                $categories = CacheManager::generateShopCategories($container, $locale);
            } else {
                return $response->withJson([
                    'success' => false,
                    'errors' => [
                        ['message' => 'Unknown locale slug']
                    ]
                ], 404);
            }
        }
        return $response->withJson([
            'success' => true,
            'data' => [
                'categories' => $categories
            ]
        ]);
    }

    public function getItem($locale, $slug, Response $response, ContainerInterface $container)
    {
        $redis = $container->get(\Predis\Client::class);
        $key = 'shop_item_' . $locale . '_' . $slug;
        if ($redis->exists($key)) {
            $render = json_decode($redis->get($key), true);
        } else {
            $this->container->get(Manager::class);
            if (array_search($locale, $this->container->get('locales')) !== false) {
                $render = CacheManager::generateShopItem($container, $locale, $slug);
                if ($render === []) {
                    return $response->withJson([
                        'success' => false,
                        'errors' => [
                            ['message' => 'Unknown shop item']
                        ]
                    ], m);
                }
            } else {
                return $response->withJson([
                    'success' => false,
                    'errors' => [
                        ['message' => 'Unknown locale slug']
                    ]
                ], 404);
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
                    ['message' => 'Invalid country code']
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
