<?php

namespace App\GraphQL\Type;

use App\GraphQL\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ShopLink extends ObjectType
{
	public function __construct()
	{
		$config = [
			'name' => 'ShopLink',
			'description' => 'A link of item in the shop',
			'fields' => [
				'id' => [
					'type' => Type::id()
				],
				'title' => [
					'type' => Type::string()
				],
				'created_at' => [
					'type' => Types::dateTime()
				],
				'updated_at' => [
					'type' => Types::dateTime()
				]
			]
		];

		parent::__construct($config);
	}
}