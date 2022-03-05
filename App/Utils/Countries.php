<?php

namespace App\Utils;

class Countries
{
    public function getCountriesDirectory(): string
    {
        return dirname(__DIR__, 2) . '/countries';
    }

    /**
     * Get the countries codes with their associated name in a given locale
     * Return null if a the locale code is invalid
     *
     * @param string $locale
     * @return array|null
     */
    public function getLocalizedCountries(string $locale): ?array
    {
        $locale = mb_strtolower($locale);
        $path = $this->getCountriesDirectory() . '/' . $locale . '.json';
        if (!file_exists($path)) {
            return null;
        }
        return json_decode(file_get_contents($path), true)['countries'];
    }

    /**
     * Known if whether or not the input ISO 3166-1 country code is valid
     *
     * @param string $code
     * @return bool
     */
    public function isCountryCodeValid(string $code): bool
    {
        $path = $this->getCountriesDirectory() . '/en.json';
        $json = json_decode(file_get_contents($path), true);
        $countries = array_filter(
            $json['countries'],
            fn ($country) => $country['code'] === mb_strtoupper($code)
        );
        $countries = array_values($countries);
        return isset($countries[0]);
    }
}
