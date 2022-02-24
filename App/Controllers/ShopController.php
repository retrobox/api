<?php

namespace App\Controllers;

use App\Auth\Session;
use App\Utils\Colissimo;
use App\Utils\CacheManager;
use App\Utils\Chronopost;
use App\Utils\Countries;
use App\Utils\LaPoste;
use Illuminate\Database\Capsule\Manager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Validator\Validator;
use Predis\Client as RedisClient;

class ShopController extends Controller
{
    public function __construct(
        private RedisClient $redis,
        ContainerInterface $container
    )
    {
        parent::__construct($container);
    }

    public function getCategories($_, ResponseInterface $response, array $args)
    {
        $locale = $args['locale'];
        if ($this->redis->exists("shop_categories_" . $locale)) {
            $categories = json_decode($this->redis->get("shop_categories_" . $locale), true);
        } else {
            $this->container->get(Manager::class);
            if (array_search($locale, $this->container->get('locales')) !== false) {
                $categories = CacheManager::generateShopCategories($this->container, $locale);
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

    public function getItem($_, ResponseInterface $response, array $args)
    {
        $locale = $args['locale'];
        $slug = $args['slug'];
        $key = 'shop_item_' . $locale . '_' . $slug;
        if ($this->redis->exists($key)) {
            $render = json_decode($this->redis->get($key), true);
        } else {
            $this->container->get(Manager::class);
            if (array_search($locale, $this->container->get('locales')) !== false) {
                $render = CacheManager::generateShopItem($this->container, $locale, $slug);
                if ($render === []) {
                    return $response->withJson([
                        'success' => false,
                        'errors' => [
                            ['message' => 'Unknown shop item']
                        ]
                    ], 404);
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

    public function getStoragePrices($_, ResponseInterface $response)
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
     * - postal_code, integer, the french city postal code
     */
    public function getShippingPrices(ServerRequestInterface $request, ResponseInterface $response)
    {
        $validator = new Validator($request->getQueryParams());
        $validator->required('weight', 'country', 'postal_code');
        $validator->notEmpty('weight', 'country', 'postal_code');
        $validator->integer('postal_code', 'weight');
        // Here we have an issue with the lefuturiste/validator library, because the value of weight can be sometime a float
        // the validator doesn't provide a float verification method, so we are kind of suck here...
        // we will use tmp a float type forcing to do the job
        if (!$validator->isValid()) {
            return $response->withJson([
                'success' => false,
                'errors'  => $validator->getErrors(true)
            ], 400);
        }
        $weight = intval($validator->getValue('weight'));
        $country = $validator->getValue('country');
        $countriesHelper = $this->container->get(Countries::class);
        if (!$countriesHelper->isCountryCodeValid($country))
            return $response->withJson([
                'success' => false,
                'errors' => [
                    ['message' => 'Invalid country code']
                ]
            ], 400);
        // TODO: add validation of the postal code
        // if the weight is zero we abort and return error!
        // the weight must also be non negative
        $postalCode = intval($validator->getValue('postal_code'));
        $colissimo = $this->container->get(Colissimo::class);
        $chronopost = $this->container->get(Chronopost::class);
        $colissimoPrice = $colissimo->getPrice($country, $weight);
        $chronopostPrice = $chronopost->getPrice($country, $postalCode, $weight);
        $chronopostPriceWithRelay = $chronopost->getPrice($country, $postalCode, $weight, true);

        return $response->withJson([
            'success' => true,
            'data' => [
                'colissimo' => $colissimoPrice,
                'chronopost' => $chronopostPrice,
                'chronopost_with_relay' => $chronopostPriceWithRelay
            ]
        ]);
    }

    public function getQueryAddress(ServerRequestInterface $request, ResponseInterface $response)
    {
        if (!$this->session()->isAdmin()) {
            return $response->withJson([
                'success' => false,
                'errors' => [['message' => 'Forbidden route']]
            ], 403);
        }
        $validator = new Validator($request->getQueryParams());
        $validator->required('query');
        $validator->notEmpty('query');
        if (!$validator->isValid())
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors(true)
            ], 400);

        $result = $this->container->get(LaPoste::class)->searchAddress($validator->getValue('query'));
        if (empty($result))
            return $response->withJson([
                'success' => false,
                'errors' => [
                    ['code' => 'unknown-address', 'message' => 'This address seems to be incorrect']
                ]
            ], 404);

        return $response->withJson([
            'success' => true,
            'data' => $result
        ]);
    }

}
