<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class Country extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Country',
            'description' => 'A world region or country',
            'fields' => [
                'code' => [
                    'type' => Type::string(),
                    'description' => 'The ISO 3166-1 country code'
                ],
                'name' => [
                    'type' => Type::string(),
                    'description' => 'The localized country name'
                ]
            ]
        ];

        parent::__construct($config);
    }
}
