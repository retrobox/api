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
					'type' => Type::string(),
                    'description' => 'A comma list of locale supported by this game'
				],
				'players' => [
					'type' => Type::int(),
                    'description' => 'Numbers of maximum players that the game allow to play with'
				],
				'thegamesdb_rating' => [
					'type' => Type::float(),
                    'description' => 'Average rating of TheGamesDB'
				],
                'igdb_rating' => [
                    'type' => Type::float(),
                    'description' => 'Average rating of IGDB users'
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
					'type' => Types::gamePlatform()
				],
				'editor' => [
					'type' => Types::gameEditor()
				],
				'tags' => [
					'type' => Type::listOf(Types::gameTag())
				],
                'medias' => [
                    'type' => Type::listOf(Types::gameMedia())
                ]
			]
		];

		parent::__construct($config);
	}
}