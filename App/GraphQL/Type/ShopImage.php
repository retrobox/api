<?php

namespace App\GraphQL\Type;

use App\GraphQL\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ShopImage extends ObjectType
{
	public function __construct($depth = false)
	{
		$config = [
			'name' => 'ShopImage',
			'description' => 'A image belong to a shop item',
			'fields' => [
				'id' => [
					'type' => Type::id()
				],
                'url' => [
                    'type' => Type::string()
                ],
                'is_main' => [
                    'type' => Type::boolean()
                ],
				'name' => [
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