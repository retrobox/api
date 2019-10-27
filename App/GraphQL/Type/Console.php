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
                'token' => [
                    'type' => Type::string(),
                    'description' => 'Authentication token for the console overlay'
                ],
                'version' => [
                    'type' => Type::string()
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
                ],
                'is_online' => [
                    'type' => Type::boolean()
                ],
                'up_time' => [
                    'type' => Type::int()
                ],
                'used_disk_space' => [
                    'type' => Type::float()
                ],
                'free_disk_space' => [
                    'type' => Type::float()
                ],
                'disk_usage' => [
                    'type' => Type::float()
                ],
                'disk_size' => [
                    'type' => Type::float()
                ],
                'cpu_temp' => [
                    'type' => Type::float()
                ],
                'gpu_temp' => [
                    'type' => Type::float()
                ],
                'ip' => [
                    'type' => Type::string()
                ],
                'wifi' => [
                    'description' => 'The wifi network SSID that the console is connected to',
                    'type' => Type::string()
                ],
                'free_memory' => [
                    'description' => 'The amount of free memory, in bytes',
                    'type' => Type::int()
                ],
                'total_memory' => [
                    'description' => 'The total amount of memory, in bytes',
                    'type' => Type::int()
                ]
            ]
        ];

        parent::__construct($config);
    }
}
