<?php

namespace App;
// simple helper

use Firebase\JWT\JWT;
use GuzzleHttp\Client;

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
        $this->client = new Client();
    }

    public function notifyDesktopLogin(array $payload): void
    {
        $this->client->post($this->baseUrl . '/notify-desktop-login', [
            'json' => $payload,
            'headers' => [
                'Authorization' => 'Bearer ' . JWT::encode(['is_api' => true], $this->jwtKey)
            ]
        ]);
    }
}
