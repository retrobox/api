<?php

namespace App\GraphQL\Type;

use App\GraphQL\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class GameEditor extends ObjectType
{
	public function __construct($depth = false)
	{
	    $depthArray = [];
	    $name = 'GameEditor';
	    if ($depth) {
	        $name .= 'WithDepth';
	        $depthArray = [
	            'games' => Type::listOf(Types::game())
            ];
        }
		$config = [
			'name' => $name,
			'description' => 'The editor of the game',
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
				'games_count' => [
				    'type' => Type::int()
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