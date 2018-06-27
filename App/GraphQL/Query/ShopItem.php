<?php

namespace App\GraphQL\Query;

use App\GraphQL\Types;
use App\Models\ShopCategory;
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
					$item = \App\Models\ShopItem::with('category')->find($args['id']);
				} elseif (isset($args['slug'])) {
					$item = \App\Models\ShopItem::query()->where('slug', '=', $args['slug'])->with('category')->first();
				}else{
					$item = \App\Models\ShopItem::find($args['id']);
				}

				return $item;
			}
		];
	}

	public static function store()
	{
		return [
			'type' => Types::shopItem(),
			'args' => [
				[
					'name' => 'item',
					'description' => 'Item to store',
					'type' => new InputObjectType([
						'name' => 'ShopItemInput',
						'fields' => [
							'title' => ['type' => Type::nonNull(Type::string())],
							'description_short' => ['type' => Type::nonNull(Type::string())],
                            'description_long' => ['type' => Type::nonNull(Type::string())],
							'price' => ['type' => Type::nonNull(Type::float())],
							'image' => ['type' => Type::nonNull(Type::string())],
							'version' => ['type' => Type::string()],
							'category_id' => ['type' => Type::nonNull(Type::string())]
						]
					])
				]
			],
			'resolve' => function ($rootValue, $args) {
		        //verify if the category exist
                $item = new \App\Models\ShopItem();
                $item->id = uniqid();
                $category = ShopCategory::find($args['item']['category_id'])->first();
                if ($category !== NULL){
                    $item->category()->associate($category);
                }
                $item->title = $args['item']['title'];
                $item->description_short = $args['item']['description_short'];
                $item->description_long = $args['item']['description_long'];
                $item->version = $args['item']['version'];
                $item->image = $args['item']['image'];
                $item->price = $args['item']['price'];
                $item->slug = str_slug($args['item']['title']);
                $item->save();
                return $item;
			}
		];
	}
}