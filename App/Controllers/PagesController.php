<?php

namespace App\Controllers;

use App\Auth\Session;
use App\Models\ShopItem;
use App\Utils\CacheManager;
use App\Utils\WebSocketServerClient;
use Illuminate\Database\Capsule\Manager;
use Lefuturiste\Jobatator\Client;
use Psr\Container\ContainerInterface;
use Slim\Http\Response;

class PagesController extends Controller
{
    public function getHome(Response $response)
    {
        return $response->withJson([
            'success' => true,
            'data' => [
                'name' => $this->container->get('app_name'),
                'env' => $this->container->get('env_name')
            ]
        ]);
    }

    public function getPing(Response $response)
    {
        return $response->withJson(['success' => true]);
    }

    public function getWebSocketConnexions(Response $response, Session $session)
    {
        if (!$session->isAdmin()) {
            return $response->withJson([
                'success' => false,
                'errors' => ['Forbidden']
            ], 403);
        }
        return $response->withJson([
            'success' => true,
            'data' => $this->container->get(WebSocketServerClient::class)->getConnexions()
        ]);
    }

    public function testSendEmailEvent(Response $response, Session $session)
    {
        if (!$session->isAdmin()) {
            return $response->withJson([
                'success' => false,
                'errors' => ['Forbidden']
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
     *
     * @param Response $response
     * @param Session $session
     * @param ContainerInterface $container
     * @return Response
     */
    public function generateShopCache(Response $response, Session $session, ContainerInterface $container)
    {
        if (!$session->isAdmin()) {
            return $response->withJson([
                'success' => false,
                'errors' => ['Forbidden']
            ], 403);
        }
        $container->get(Manager::class);
        $categories = [];
        foreach ($container->get('locales') as $locale) {
            $categories[] = CacheManager::generateShopCategories($container, $locale);
        }
        $items = ShopItem::all()->toArray();
        $itemsCached = [];
        foreach ($items as $item) {
            $itemsCached[] = CacheManager::generateShopItem($container, $item['locale'], $item['slug']);
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
