<?php

namespace App\Utils;
// simple helper

use Firebase\JWT\JWT;
use GuzzleHttp\Client;

class WebSocketServerClient
{
    /**
     * The JWT key used to authenticate with the ws server
     *
     * @var string
     */
    public string $jwtKey = '';

    /**
     * @var string
     */
    public string $baseUrl = '';

    /**
     * @var Client
     */
    private Client $client;

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

    public function getConnexions()
    {
        $res = $this->client->get($this->baseUrl . '/connections');
        return json_decode($res->getBody()->getContents(), true)['data'];
    }

    /**
     * Return the status of a given console, assuming that the console id actually exist in the database
     *
     * @param string $consoleId
     * @return mixed
     */
    public function getConsoleStatus(string $consoleId)
    {
        $res = $this->client->get($this->baseUrl . '/console/' . $consoleId, [
            'http_errors' => false
        ]);
        $json = json_decode($res->getBody()->getContents(), true);

        return [
            'online' => $json['success'],
            'status' => $json['success'] ? $json['data'] : null
        ];
    }

    public function shutdownConsole(string $consoleId): bool
    {
        $res = $this->client->get($this->baseUrl . '/console/' . $consoleId . '/shutdown', [
            'http_errors' => false
        ]);
        return $res->getStatusCode() === 200;
    }

    public function rebootConsole(string $consoleId): bool
    {
        $res = $this->client->get($this->baseUrl . '/console/' . $consoleId . '/reboot', [
            'http_errors' => false
        ]);
        return $res->getStatusCode() === 200;
    }

    /**
     * Will force the overlay process to disconnect and exit (very dangerous!)
     *
     * @param string $consoleId
     * @return bool
     */
    public function killOverlay(string $consoleId): bool
    {
        $res =  $this->client->get($this->baseUrl . '/console/' . $consoleId . '/kill-overlay', [
            'http_errors' => false
        ]);
        return $res->getStatusCode() === 200;
    }

    public function openConsoleTerminalSession(string $consoleId, string $webSessionId, string $userId): bool
    {
        $res = $this->client->get($this->baseUrl . '/console/' . $consoleId . '/open-terminal-session', [
            'http_errors' => false,
            'headers' => [
                'X-Web-Session' => $webSessionId,
                'X-User-Id' => $userId
            ]
        ]);
        return $res->getStatusCode() === 200;
    }

    public function serverIsOnline(): bool
    {
        $response = $this->client->get($this->baseUrl . '/ping');
        return json_decode($response->getBody()->getContents(), true)['success'] === true;
    }
}
