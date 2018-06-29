<?php
return new \GraphQL\Type\Schema([
	'query' => (new \App\GraphQL\Type\Query()),
	'mutation' => (new \App\GraphQL\Type\Mutations()),

	//types
	'game' => (new \App\GraphQL\Type\Game()),
	'post' => (new \App\GraphQL\Type\Post()),
	//shop
	'shop_item' => (new \App\GraphQL\Type\ShopItem()),
	'shop_category' => (new \App\GraphQL\Type\ShopCategory())
]);