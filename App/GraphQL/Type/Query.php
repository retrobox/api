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
				'getManyGames' => \App\GraphQL\Query\Game::getMany(),
				'getOneGame' => \App\GraphQL\Query\Game::getOne(),
//				'storeGame' => \App\GraphQL\Query\Game::store(),
			]
		];

		parent::__construct($config);
	}
}