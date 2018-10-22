<?php

namespace App\GraphQL\Type;

use App\GraphQL\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class GameMedia extends ObjectType
{
	public function __construct()
	{
		$config = [
			'name' => 'GameMedia',
			'description' => 'A media of a game or a platform (image/video)',
			'fields' => [
				'id' => [
					'type' => Type::id()
				],
				'type' => [
					'type' => Type::string()
				],
				'url' => [
					'type' => Type::string()
				],
                'is_main' => [
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