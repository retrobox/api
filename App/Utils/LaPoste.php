<?php

namespace App\Utils;

use GuzzleHttp\Client;

class LaPoste
{
    /**
     * @var Client
     */
    private Client $client;

    private string $endpoint = "https://api.laposte.fr/controladresse/v1";

    public function __construct(string $apiKey)
    {
        $this->client = new Client(['headers' => ['X-Okapi-Key' => $apiKey]]);
    }

    /**
     * Look for an address into the public laposte database
     * The address is compacted as a single string
     * The search result is a array of possible address (address object)
     * Each address object contain an 'address' key which is the valid address as a single string
     * It also contain an 'code' key which is the id of the address in the public laposte database
     *
     * @param string $query
     * @return array
     */
    public function searchAddress(string $query): array
    {
        $res = $this->client->get($this->endpoint . '/adresses', ['query' => ['q' => $query]]);
        $content = json_decode($res->getBody()->getContents(), true);
        return array_map(fn ($a) => ['address' => $a['adresse'], 'code' => $a['code']], $content);
    }
}