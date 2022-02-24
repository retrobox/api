<?php

namespace App\Controllers;

use App\Utils\WebSocketServerClient;
use Exception;
use Illuminate\Database\Capsule\Manager;
use Lefuturiste\Jobatator\Client;
use Psr\Http\Message\ResponseInterface;

class HealthController extends Controller
{
    public function getHealth($_, ResponseInterface $response)
    {
        // 1. Verify MySQL
        $issues = [];
        $mysqlConnexion = null;
        try {
            $mysqlConnexion = $this->container->get(Manager::class)->getConnection();
            $mysqlConnexion->reconnect();
        } catch (Exception $exception) {
            $mysqlConnexion = null;
            $issues[] = [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ];
        }

        // 2. Verify Redis
        $redisResponse = null;
        $redisClient = null;
        try {
            $redisClient = $this->container->get(\Predis\Client::class);
            $redisResponse = $redisClient->ping();
        } catch (Exception $exception) {
            $issues[] = [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ];
        }

        // 3. Verify Web Socket
        $webSocketClient = null;
        $webSocketOnline = false;
        try {
            $webSocketClient = $this->container->get(WebSocketServerClient::class);
            $webSocketOnline = $webSocketClient->serverIsOnline();
        } catch (Exception $exception) {
            $issues[] = [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ];
        }

        // 4. Verify Jobatator
        $queue = null;
        try {
            $queue = $this->container->get(Client::class);
        } catch (Exception $exception) {
            $issues[] = [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ];
        }

        return $response->withJson([
            'success' => true,
            'data' => [
                'have_issues' => $issues !== [],
                'issues' => $issues,
                'connexions' => [
                    'jobatator' => $queue !== null && $queue->hasConnexion(),
                    'mysql' =>
                        $mysqlConnexion !== null &&
                        $mysqlConnexion->select('SHOW TABLES') !== null,
                    'redis' =>
                        $redisClient !== null &&
                        $redisResponse !== null &&
                        $redisResponse->getPayload() === 'PONG' &&
                        $redisClient->set("foo", "bar") &&
                        $redisClient->get("foo") === "bar" && $redisClient->del(["foo"]),
                    'websocket_server' =>
                        $webSocketClient !== null &&
                        $webSocketOnline
                ]
            ]
        ], $issues !== [] ? 500 : 200);
    }
}
