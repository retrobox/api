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
                ],
                'image_url' => [
                    'type' => Type::string(),
                    'description' => 'The url to download the image of this console version to flash the sd card with'
                ]
            ]
        ];

        parent::__construct($config);
    }
}