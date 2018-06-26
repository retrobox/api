<?php

namespace App\GraphQL\Type;

use App\GraphQL\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ShopItem extends ObjectType
{
	public function __construct($depth = false)
	{
		if ($depth){
			$depthArray = [
				'category' => [
					'type' => Types::shopCategoryWithDepth()
				]
			];
			$name = "ShopItemWithDepth";
		}else{
			$name = "ShopItem";
			$depthArray = [];
		}
		$config = [
			'name' => $name,
			'description' => 'A item in the shop',
			'fields' => array_merge([
				'id' => [
					'type' => Type::id()
				],
				'title' => [
					'type' => Type::string()
				],
				'image' => [
					'type' => Type::string()
				],
				'slug' => [
					'type' => Type::string()
				],
				'description_short' => [
					'type' => Type::string()
				],
				'description_long' => [
					'description' => "Written in markdown",
					'type' => Type::string()
				],
				'price' => [
					'type' => Type::float()
				],
				'version' => [
					'type' => Type::string()
				],
				'link' => [
					'type' => Types::shopLink()
				],
				'created_at' => [
					'type' => Types::dateTime()
				],
				'updated_at' => [
					'type' => Types::dateTime()
				]
			],$depthArray)
		];

		parent::__construct($config);
	}
}