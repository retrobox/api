<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ShippingAddress extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'ShippingAddress',
            'description' => 'A user shipping address',
            'fields' => [
                'first_name' => ['type' => Type::string()],
                'last_name' => ['type' => Type::string()],
                'first_line' => ['type' => Type::string()],
                'second_line' => ['type' => Type::string()],
                'postal_code' => ['type' => Type::int()],
                'city' => ['type' => Type::string()],
                'country' => ['type' => Type::string()]
            ]
        ];

        parent::__construct($config);
    }
}