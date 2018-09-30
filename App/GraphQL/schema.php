<?php
return new \GraphQL\Type\Schema([
	'query' => (new \App\GraphQL\Type\Query()),
	'mutation' => (new \App\GraphQL\Type\Mutations()),

	//types
    //games
	'game' => (new \App\GraphQL\Type\Game()),
	'editor' => (new \App\GraphQL\Type\Editor()),
	'genre' => (new \App\GraphQL\Type\Genre()),
	//blog
	'post' => (new \App\GraphQL\Type\Post()),
	//shop
	'shop_item' => (new \App\GraphQL\Type\ShopItem()),
	'shop_category' => (new \App\GraphQL\Type\ShopCategory()),
    'shop_order' => (new \App\GraphQL\Type\ShopOrder()),
	'console' => (new \App\GraphQL\Type\Console())
]);