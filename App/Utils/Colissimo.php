<?php

namespace App\Utils;

use GuzzleHttp\Client;

class Colissimo
{
    /**
     * @var Client
     */
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([]);
    }

    /**
     * Get the price of a shipment using Colissimo shipping service
     *
     * @param string $to The ISO code of the destination country
     * @param int $weight The weight of the packet in SI grams
     * @return int PRICE IN CENTS
     */
    public function getPrice(string $to, int $weight): int
    {
        $res = $this->client->post('https://www.laposte.fr/colissimo-en-ligne/getprice', [
            'form_params' => [
                'fromIsoCode' => 'fr',
                'toIsoCode' => mb_strtolower($to),
                'weight' => $weight / 1000
            ]
        ]);
        $json = json_decode($res->getBody()->getContents(), true);
        return (int) ($json['value'] * 100);
    }
}
