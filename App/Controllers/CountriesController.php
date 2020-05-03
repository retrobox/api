<?php

namespace App\Controllers;


use App\Utils\Countries;
use Slim\Http\Response;

class CountriesController extends Controller
{
    public function getCountries($locale, Response $response)
    {
        $countries = $this->container->get(Countries::class)->getLocalizedCountries($locale);
        if ($countries === NULL)
            return $response->withJson([
                'success' => false,
                'errors' => [
                    ['message' => 'Invalid locale code']
                ]
            ], 400);
        return $response->withJson([
            'success' => true,
            'data' => $countries
        ]);
    }
}
