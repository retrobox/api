<?php

namespace App\GraphQL\Type;

use App\GraphQL\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class GameRom extends ObjectType
{
	public function __construct($depth = false)
	{
        $config = [
            'name' => 'GameRom',
            'description' => 'A game rom file',
            'fields' => [
                'id' => [
                    'type' => Type::id()
                ],
                'size' => [
                    'type' => Type::int()
                ],
                'url' => [
                    'type' => Type::string()
                ],
                'sha1_hash' => [
                    'type' => Type::string()
                ],
                'last_checked_at' => [
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
