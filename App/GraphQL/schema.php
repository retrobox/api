<?php
return new \GraphQL\Type\Schema([
	'query' => (new \App\GraphQL\Type\Query()),
	'mutation' => (new \App\GraphQL\Type\Mutations()),
	'game' => (new \App\GraphQL\Type\Game())
]);