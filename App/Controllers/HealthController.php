<?php

namespace App\Controllers;

use App\Utils\WebSocketServerClient;
use Illuminate\Database\Capsule\Manager;
use Lefuturiste\RabbitMQPublisher\Client;
use Slim\Http\Response;

class HealthController extends Controller
{
    public function getHealth(Response $response)
    {
        $issues = [];
        $rabbitMqConnexion = null;
        try {
            $rabbitMqConnexion = $this->container->get(Client::class);
        } catch (\Exception $exception) {
            $issues[] = [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ];
        }
        $mysqlConnexion = null;
        try {
            $mysqlConnexion = $this->container->get(Manager::class)->getConnection();
            $mysqlConnexion->reconnect();
        } catch (\Exception $exception) {
            $mysqlConnexion = null;
            $issues[] = [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ];
        }
        $redisResponse = null;
        $redisClient = null;
        try {
            $redisClient = $this->container->get(\Predis\Client::class);
            $redisResponse = $redisClient->ping();
        } catch (\Exception $exception) {
            $issues[] = [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ];
        }

        $webSocketClient = null;
        $webSocketOnline = false;
        try {
            $webSocketClient = $this->container->get(WebSocketServerClient::class);
            $webSocketOnline = $webSocketClient->serverIsOnline();
        } catch (\Exception $exception) {
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
                    'rabbitmq' =>
                        $rabbitMqConnexion !== null &&
                        $rabbitMqConnexion->connexion !== null &&
                        $rabbitMqConnexion->connexion->getConnection(),
                    'mysql' =>
                        $mysqlConnexion !== null &&
                        $mysqlConnexion->select('SHOW TABLES') !== null,
                    'redis' =>
                        $redisClient !== null &&
                        $redisResponse !== null &&
                        $redisResponse->getPayload() === 'PONG' &&
                        $redisClient->set("foo", "bar") &&
                        $redisClient->get("foo") === "bar",
                    'websocket_server' =>
                        $webSocketClient !== null &&
                        $webSocketOnline
                ]
            ]
        ]);
    }
}
