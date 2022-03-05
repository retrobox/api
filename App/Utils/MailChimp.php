<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpDocMissingThrowsInspection */

namespace App\Utils;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class MailChimp
{
    private string $apiKey;
    private string $zone;
    private Client $client;
    private string $endpoint;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->zone = substr($apiKey, -4);
        $this->endpoint = "https://{$this->zone}.api.mailchimp.com/3.0";
        $this->client = new Client(['http_errors' => false]);
    }

    /**
     * @param string $listId
     * @param string $email
     * @return ResponseInterface
     */
    public function addSubscriber(string $listId, string $email): ResponseInterface
    {
        return $this->client->request(
            'POST',
            $this->endpoint . "/lists/{$listId}/members",
            [
                'json' => ['email_address' => $email, 'status' => 'subscribed'],
                'auth' => [
                    'u',
                    $this->apiKey
                ]
            ]
        );
    }
}
