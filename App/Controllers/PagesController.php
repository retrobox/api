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
                'env' => $this->container->get('env_name'),
                'test_mode' => $this->container->get('app_test')
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
                'errors' => [['message' => 'Forbidden route']]
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
     * Erase every actual data of the database.
     * Will remove every rows of every tables except for the phinxlog table in the database.
     * This is a really, really dangerous route only meant to be used for test purposes and test purposes only.
     * If the app is not in test mode or if the database is not named with the 'test' keyword, this wont work.
     *
     * @param Response $response
     * @return Response
     */
    public function getDangerouslyTruncateTables(Response $response)
    {
        if (!$this->container->get('app_test'))
            return $response->withJson([
                'success' => false,
                'errors' => [['message' => 'Not in test mode']]
            ], 403);

        $pdo = $this->container->get(Manager::class)->getConnection();

        if (strpos($pdo->getDatabaseName(), 'test') === false)
            return $response->withJson([
                'success' => false,
                'errors' => [['message' => 'Cannot truncate a non test database']]
            ], 403);

        $tables = $pdo->getPdo()->query("SHOW TABLES")->fetchAll();
        $truncateRaw = '';
        $tables = array_filter($tables, fn ($t) => $t[0] !== 'phinxlog');
        foreach ($tables as $table) {
            $truncateRaw .= 'TRUNCATE ' . $table[0] . '; ';
        }

        return $response->withJson([
            'success' => true,
            'data' => [
                'raw' => $truncateRaw
            ]
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
                'errors' => [
                    ['message' => 'Forbidden']
                ]
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
