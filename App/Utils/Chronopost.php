<?php

namespace App\Utils;

use App\App;

class Chronopost
{
    private array $config;

    public function __construct()
    {
        $path = App::getBasePath() . '/public/chronopost.json';
        $this->config = json_decode(file_get_contents($path), true);
    }

    public function getPriceByWeight(array $values, int $weight): int
    {
        foreach ($values as $value)
            if ($weight >= $value['from'] && $weight <= $value['to'])
                return $value['price'] * 100;
        return 0;
    }

    /**
     * Will return the price for a specified country, postal_code, weight, relay shipping
     * Return 0 (null price) if out of range $weight or if country not supported, the shipping method is then considered as unsupported.
     *
     * @param string $toCountry The ISO code of the destination country
     * @param int $toPostalCode French postal code
     * @param int $weight The weight of the packet in SI grams
     * @param bool $relay Flag with relay chronopost
     * @return int PRICE IN CENTS
     */
    public function getPrice(string $toCountry, int $toPostalCode, int $weight, bool $relay = false): int
    {
        // corsica's cities postal code begin with 20 so between 20000 and 21000
        if ($toCountry == 'FR' && !($toPostalCode > 20000 && $toPostalCode < 21000))
            $key = 'chronopost_fr_13h';
        else if (in_array($toCountry, $this->config['EU_ISO']))
            $key = 'chronopost_eu_48h';
        else
            return 0;
        if ($relay)
            $key .= "_relay";
        return $this->getPriceByWeight($this->config[$key], $weight);
    }
}