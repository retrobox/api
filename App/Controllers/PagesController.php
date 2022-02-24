<?php

namespace App\Controllers;

use App\Auth\Session;
use App\Models\ShopItem;
use App\Utils\CacheManager;
use App\Utils\WebSocketServerClient;
use Illuminate\Database\Capsule\Manager;
use Lefuturiste\Jobatator\Client;
use Psr\Http\Message\ResponseInterface;

class PagesController extends Controller
{
    public function getHome($_, ResponseInterface $response)
    {
        return $response->withJson([
            'success' => true,
            'data' => [
                'name' => $this->container->get('app_name'),
                'env' => $this->container->get('env_name'),
                'test_mode' => $this->container->get('app_test')
            ]
        ]);
    }

    public function getPing($_, ResponseInterface $response)
    {
        return $this->json($response);
    }

    public function getWebSocketConnexions($_, ResponseInterface $response)
    {
        if (!$this->session()->isAdmin()) {
            return $response->withJson([
                'success' => false,
                'errors' => [['message' => 'Forbidden route']]
            ], 403);
        }
        return $response->withJson([
            'success' => true,
            'data' => $this->container->get(WebSocketServerClient::class)->getConnexions()
        ]);
    }

    public function testSendEmailEvent($_, ResponseInterface $response, Session $session)
    {
        if (!$session->isAdmin()) {
            return $response->withJson([
                'success' => false,
                'errors' => [['message' => 'Forbidden']]
            ], 403);
        }
        $queue = $this->container->get(Client::class);
        $queue->publish('test.email', ['lel' => 'lel']);
        return $response->withJson([
            'success' => true
        ]);
    }

    /**
     * This route will generate all the cache of the shop
     */
    public function generateShopCache($_, ResponseInterface $response)
    {
        if (!$this->session()->isAdmin()) {
            return $response->withJson([
                'success' => false,
                'errors' => [
                    ['message' => 'Forbidden']
                ]
            ], 403);
        }
        $this->container->get(Manager::class);
        $categories = [];
        foreach ($this->container->get('locales') as $locale) {
            $categories[] = CacheManager::generateShopCategories($this->container, $locale);
        }
        $items = ShopItem::all()->toArray();
        $itemsCached = [];
        foreach ($items as $item) {
            $itemsCached[] = CacheManager::generateShopItem($this->container, $item['locale'], $item['slug']);
        }
        return $response->withJson([
            'success' => true,
            'data' => [
                'categories' => $categories,
                'items' => $itemsCached
            ]
        ]);
    }
}
