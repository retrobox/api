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
				//shop item
				'getManyShopItems' => \App\GraphQL\Query\ShopItem::getMany(),
				'getOneShopItem' => \App\GraphQL\Query\ShopItem::getOne(),
                //shop category
                'getManyShopCategories' => \App\GraphQL\Query\ShopCategory::getMany(),
                'getOneShopCategory' => \App\GraphQL\Query\ShopCategory::getOne(),

                //users
                'getManyUsers' => \App\GraphQL\Query\User::getMany(),
                'getOneUser' => \App\GraphQL\Query\User::getOne()
			]
		];

		parent::__construct($config);
	}
}