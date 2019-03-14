<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class MailChimp
{
    private $apiKey;
    private $zone;
    /**
     * @var Client
     */
    private $client;
    private $endpoint;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->zone = substr($apiKey, -4);
        $this->endpoint = "https://{$this->zone}.api.mailchimp.com/3.0";
        $this->client = new Client(['http_errors' => false]);
    }

    public function addSubscriber($listId, $email): Response
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
