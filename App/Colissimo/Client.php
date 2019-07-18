<?php

namespace App\Colissimo;

class Client
{

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client([]);
    }

    /**
     * Get the price of a shipment using Colissimo shipping service
     *
     * @param string $from The ISO code of the departure country
     * @param string $to The ISO code of the destination country
     * @param int $weight The weight of the packet in SI grams
     *
     * @return float
     */
    public function getPrice(string $from, string $to, int $weight): float
    {
        $res = $this->client->get('https://www.laposte.fr/professionnel/configurator/getConfiguratorNetPrice', [
            'query' => [
                'fromisocode' => mb_strtolower($from),
                'toisocode' => mb_strtolower($to),
                'weight' => $weight / 1000,
                'contenanttype' => 'COLIS_STANDARD'
            ]
        ]);
        $json = json_decode($res->getBody()->getContents(), true);
        return (float) $json['value'];
    }
}
