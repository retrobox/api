<?php

namespace App\GraphQL\Type;

use App\GraphQL\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ShopCategory extends ObjectType
{
	public function __construct($depth = false)
	{
		if ($depth){
			$depthArray = [
			 	'items' => [
			 		'type' => Type::listOf(Types::shopItem())
				]
			];
		}else{
			$depthArray = [];
		}
		$config = [
			'name' => 'ShopCategory',
			'description' => 'A category of item in the shop',
			'fields' => array_merge([
				'id' => [
					'type' => Type::id()
				],
				'title' => [
					'type' => Type::string()
				],
                'is_customizable' => [
                    'type' => Type::boolean()
                ],
                'locale' => [
                    'type' => Type::string()
                ],
				'created_at' => [
					'type' => Types::dateTime()
				],
				'updated_at' => [
					'type' => Types::dateTime()
				]
			], $depthArray)
		];

		parent::__construct($config);
	}
}