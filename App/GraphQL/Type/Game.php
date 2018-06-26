<?php

namespace App\GraphQL\Type;

use App\GraphQL\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class Game extends ObjectType
{
	public function  __construct()
	{
		$config = [
			'name' => 'Game',
			'description' => 'The retrogame',
			'fields' => [
				'id' => [
					'type' => Type::id()
				],
				'name' => [
					'type' => Type::string()
				],
				'esrb_level' => [
					'type' => Type::string(),
					'description' => 'The Entertainment Software Rating Board level of the game'
				],
				'locale' => [
					'type' => Type::string()
				],
				'players' => [
					'type' => Type::int()
				],
				'thegamesdb_rating' => [
					'type' => Type::float()
				],
				'description' => [
					'type' => Type::string()
				],
				'created_at' => [
					'type' => Types::dateTime()
				],
				'updated_at' => [
					'type' => Types::dateTime()
				],
				'released_at' => [
					'type' => Types::dateTime()
				],
				'platform' => [
					'type' => Types::platform()
				],
				'editor' => [
					'type' => Types::editor()
				],
				'genres' => [
					'type' => Type::listOf(Types::genre())
				]
			]
		];

		parent::__construct($config);
	}
}