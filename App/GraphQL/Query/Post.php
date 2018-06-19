<?php

namespace App\GraphQL\Query;

use App\GraphQL\Types;
use Error;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class Post
{
	public static function getMany()
	{
		return [
			'type' => Type::listOf(Types::post()),
			'description' => 'Get many posts',
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
				return \App\Models\Post::query()
					->limit($args['limit'])
					->orderBy($args['orderBy'], strtolower($args['orderDir']))
					->get();
			}
		];
	}

	public static function getOne()
	{
		return [
			'type' => Types::post(),
			'description' => 'Get a post by id',
			'args' => [
				[
					'name' => 'id',
					'description' => 'The Id of the post',
					'type' => Type::string()
				]
			],
			'resolve' => function ($rootValue, $args) {
				$post = \App\Models\Post::find($args['id']);
				if ($post == NULL){
					//404
					throw new Error("The post was not found");
				}else{
					return $post
						->first();
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
							'name' => ['type' => Type::nonNull(Types::nonEmpty(Type::string()))],
							'description' => ['type' => Types::nonEmpty(Type::string())],
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