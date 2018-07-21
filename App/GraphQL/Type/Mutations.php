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
                'updateShopItem' => \App\GraphQL\Query\ShopItem::update(),
                //shop category
                'storeShopCategory' => \App\GraphQL\Query\ShopCategory::store(),
                'updateShopCategory' => \App\GraphQL\Query\ShopCategory::update(),
                'destroyShopCategory' => \App\GraphQL\Query\ShopCategory::destroy()
			]
		];

		parent::__construct($config);
	}
}