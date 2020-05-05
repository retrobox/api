<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ConsoleVersion extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'ConsoleVersion',
            'description' => 'A console version',
            'fields' => [
                'id' => [
                    'type' => Type::string(),
                    'description' => 'A class version string format'
                ]
            ]
        ];

        parent::__construct($config);
    }
}