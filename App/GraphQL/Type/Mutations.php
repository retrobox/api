<?php

namespace App\GraphQL\Type;

use App\GraphQL\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class Mutations extends ObjectType {
	public function __construct()
	{
		$config = [
			'name' => 'Mutations',
			'fields' => [
				'storeGame' => \App\GraphQL\Query\Game::store(),
				//post
				'storePost' => \App\GraphQL\Query\Post::store(),
                //user
                'updateUser' => \App\GraphQL\Query\User::update(),
                //shop item
                'storeShopItem' => \App\GraphQL\Query\ShopItem::store(),
                'storeShopCategory' => \App\GraphQL\Query\ShopCategory::store()
			]
		];

		parent::__construct($config);
	}
}