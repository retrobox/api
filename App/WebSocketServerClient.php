<?php

namespace App;
// simple helper

use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class WebSocketServerClient
{
    /**
     * @var string
     */
    public $jwtKey = '';

    /**
     * @var string
     */
    public $baseUrl = '';

    /**
     * @var Client
     */
    private $client;

    public function __construct(string $jwtKey, string $webSocketServerBaseUrl)
    {
        $this->jwtKey = $jwtKey;
        $this->baseUrl = $webSocketServerBaseUrl;
        $this->client = new Client([
            'headers' => [
                'Authorization' => 'Bearer ' . JWT::encode(['isApi' => true], $this->jwtKey)
            ]
        ]);
    }

    public function notifyDesktopLogin(array $payload): void
    {
        $this->client->post($this->baseUrl . '/notify-desktop-login', [
            'json' => $payload
        ]);
    }

    public function getConnexions(): ResponseInterface
    {
        return $this->client->get($this->baseUrl . '/connections');
    }

    /**
     * Return the status of a given console, assuming that the console id actually exist in the database
     *
     * @param string $consoleId
     * @return mixed
     */
    public function getConsoleStatus(string $consoleId)
    {
        $res = $this->client->get($this->baseUrl . '/console/' . $consoleId . '');
        $json = json_decode($res->getBody()->getContents(), true);

        return [
            'online' => $json['success'],
            'status' => $json['success'] ? $json['data'] : null
        ];
    }

    public function serverIsOnline(): bool
    {
        $response = $this->client->get($this->baseUrl . '/ping');
        return json_decode($response->getBody()->getContents(), true)['success'] === true;
    }
}
