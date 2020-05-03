<?php

namespace App\GraphQL\Query;

use App\GraphQL\Types;
use Exception;
use GraphQL\Type\Definition\Type;
use Psr\Container\ContainerInterface;

class Countries
{
    public static function getMany()
    {
        return [
            'type' => Type::listOf(Types::country()),
            'description' => 'Get all world-wide countries with a particular language',
            'args' => [
                [
                    'name' => 'locale',
                    'description' => 'A supported locale code',
                    'type' => Type::string(),
                    'defaultValue' => 'en'
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                $countries = $container->get(\App\Utils\Countries::class)->getLocalizedCountries($args['locale']);
                if ($countries === NULL)
                    return new Exception('Invalid locale code', 404);
                return $countries;
            }
        ];
    }
}
