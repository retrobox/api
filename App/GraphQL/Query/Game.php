<?php

namespace App\GraphQL\Query;

use App\GraphQL\Types;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class Game
{
	public static function getMany()
	{
		return [
			'type' => Type::listOf(Types::game()),
			'description' => 'Get many games',
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
				return \App\Models\Game::query()
					->with('platform', 'editor', 'genres')
					->limit($args['limit'])
					->orderBy($args['orderBy'], strtolower($args['orderDir']))
					->get();
			}
		];
	}

	public static function getOne()
	{
		return [
			'type' => Types::game(),
			'description' => 'Get a game by id',
			'args' => [
				[
					'name' => 'id',
					'description' => 'The Id of the game',
					'type' => Type::string()
				]
			],
			'resolve' => function ($rootValue, $args) {
				return \App\Models\Game::find($args['id'])
					->with('platform', 'editor', 'genres')
					->first();
			}
		];
	}

	public static function store()
	{
		return [
			'type' => Types::game(),
			'args' => [
				[
					'name' => 'game',
					'description' => 'Game to store',
					'type' => new InputObjectType([
						'name' => 'GameInput',
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