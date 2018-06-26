<?php

namespace App\GraphQL\Query;

use App\GraphQL\Types;
use Error;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ShopItem
{
	public static function getMany()
	{
		return [
			'type' => Type::listOf(Types::shopItem()),
			'description' => 'Get many shop item',
			'args' => [
				[
					'name' => 'limit',
					'description' => 'Number of items to get',
					'type' => Type::int(),
					'defaultValue' => 10
				],
				[
					'name' => 'orderBy',
					'description' => 'Order by a field',
					'type' => Type::string(),
					'defaultValue' => 'created_at'
				],
				[
					'name' => 'orderDir',
					'description' => 'Direction of the order',
					'type' => Type::string(),
					'defaultValue' => 'desc'
				]
			],
			'resolve' => function ($rootValue, $args) {
				return \App\Models\ShopItem::query()
					->limit($args['limit'])
					->orderBy($args['orderBy'], strtolower($args['orderDir']))
					->get();
			}
		];
	}

	public static function getOne()
	{
		return [
			'type' => Types::shopItemWithDepth(),
			'description' => 'Get a shop item by id',
			'args' => [
				[
					'name' => 'id',
					'description' => 'The Id of the shop item',
					'type' => Type::string()
				],
				[
					'name' => 'slug',
					'description' => 'The Slug of the shop item',
					'type' => Type::string()
				]
			],
			'resolve' => function ($rootValue, $args) {
				if (isset($args['id'])) {
					$item = \App\Models\ShopItem::find($args['id']);
				} elseif (isset($args['slug'])) {
					$item = \App\Models\ShopItem::query()->where('slug', '=', $args['slug'])->with('category', 'link')->get();
				}else{
					$item = \App\Models\ShopItem::find($args['id']);
				}
				if ($item == NULL) {
					return $item;
				} else {
					return $item->first();
				}
			}
		];
	}

	public static function store()
	{
		return [
			'type' => Types::post(),
			'args' => [
				[
					'name' => 'post',
					'description' => 'Post to store',
					'type' => new InputObjectType([
						'name' => 'PostInput',
						'fields' => [
							'name' => ['type' => Type::nonNull(Type::string())],
							'description' => ['type' => Type::nonNull(Type::string())],
							'content' => ['type' => Type::nonNull(Type::string())],
							'image' => ['type' => Type::nonNull(Type::string())]
						]
					])
				]
			],
			'resolve' => function ($rootValue, $args) {
				return [
					'id' => 'jdjs23'
				];
			}
		];
	}
}