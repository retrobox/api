<?php

namespace App\GraphQL\Type;

use App\GraphQL\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class User extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'User',
            'description' => 'A user account',
            'fields' => [
                'id' => [
                    'type' => Type::string(),
                    'description' => 'The user STAIL.EU uuid'
                ],
                'last_username' => [
                    'type' => Type::string()
                ],
                'last_email' => [
                    'type' => Type::string()
                ],
                'last_avatar' => [
                    'type' => Type::string()
                ],
                'last_user_agent' => [
                    'type' => Type::string()
                ],
                'last_login_at' => [
                    'type' => Types::dateTime()
                ],
                'is_admin' => [
                    'type' => Type::boolean()
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