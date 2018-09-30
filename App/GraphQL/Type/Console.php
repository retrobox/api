<?php

namespace App\GraphQL\Type;

use App\GraphQL\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class Console extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Console',
            'description' => "A user's console",
            'fields' => [
                'id' => [
                    'type' => Type::id()
                ],
                'user' => [
                    'type' => Types::user()
                ],
                'order' => [
                    'type' => Types::shopOrder()
                ],
                'storage' => [
                    'type' => Type::string()
                ],
                'color' => [
                    'type' => Type::string()
                ],
                'first_boot_at' => [
                    'type' => Types::dateTime()
                ],
                'created_at' => [
                    'type' => Types::dateTime()
                ],
                'updated_at' => [
                    'type' => Types::dateTime()
                ]
            ]
        ];

        parent::__construct($config);
    }
}