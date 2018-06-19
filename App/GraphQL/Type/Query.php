<?php

namespace App\GraphQL\Type;

use App\GraphQL\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class Query extends ObjectType {
	public function __construct()
	{
		$config = [
			'name' => 'Query',
			'fields' => [
				//games
				'getManyGames' => \App\GraphQL\Query\Game::getMany(),
				'getOneGame' => \App\GraphQL\Query\Game::getOne(),
//				'storeGame' => \App\GraphQL\Query\Game::store(),

				//posts
				'getManyPosts' => \App\GraphQL\Query\Post::getMany(),
				'getOnePost' => \App\GraphQL\Query\Post::getOne(),
			]
		];

		parent::__construct($config);
	}
}