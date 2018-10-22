<?php

namespace App\GraphQL\Type;

use App\GraphQL\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class GameTag extends ObjectType
{
	public function __construct($depth = false)
	{
        $depthArray = [];
        $name = 'GameTag';
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
			'description' => 'The tag of the game',
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
				'icon' => [
					'type' => Type::string()
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