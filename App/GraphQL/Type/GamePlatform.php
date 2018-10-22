<?php

namespace App\GraphQL\Type;

use App\GraphQL\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class GamePlatform extends ObjectType
{
	public function __construct($depth = false)
	{
        $depthArray = [];
        $name = 'GamePlatform';
        if ($depth){
            $name .= 'WithDepth';
            $depthArray = [
                'games' => [
                    'type' => Type::listOf(Types::game())
                ],
                'games_count' => [
                    'type' => Type::int()
                ]
            ];
        }
		$config = [
			'name' => $name,
			'description' => 'The platform of the game',
			'fields' => array_merge([
				'id' => [
					'type' => Type::id()
				],
				'name' => [
					'type' => Type::string()
				],
				'description' => [
					'type' => Type::string()
				],
                'manufacturer' => [
                    'type' => Type::string()
                ],
                'cpu' => [
                    'type' => Type::string()
                ],
                'memory' => [
                    'type' => Type::string()
                ],
                'graphics' => [
                    'type' => Type::string()
                ],
                'sound' => [
                    'type' => Type::string()
                ],
                'display' => [
                    'type' => Type::string()
                ],
                'max_controllers' => [
                    'type' => Type::string()
                ],
                'thegamesdb_rating' => [
                    'type' => Type::string()
                ],
				'medias' => [
				    'type' => Type::listOf(Types::gameMedia())
                ],
				'created_at' => [
					'type' => Types::dateTime()
				],
				'updated_at' => [
					'type' => Types::dateTime()
				]
			], $depthArray)
		];

		parent::__construct($config);
	}
}