<?php

namespace App\GraphQL\Query;

use App\GraphQL\Types;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class User
{
	public static function getMany()
	{
		return [
			'type' => Type::listOf(Types::user()),
			'description' => 'Get many users',
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
				return \App\Models\User::query()
					->limit($args['limit'])
					->orderBy($args['orderBy'], strtolower($args['orderDir']))
					->get();
			}
		];
	}

	public static function getOne()
	{
		return [
			'type' => Types::user(),
			'description' => 'Get a user by id',
			'args' => [
				[
					'name' => 'id',
					'description' => 'The STAIL.EU uuid of the user account',
					'type' => Type::string()
				]
			],
			'resolve' => function ($rootValue, $args) {
				$user = \App\Models\User::find($args['id']);
				if ($user == NULL){
					//no found
					return $user;
				}else{
					return $user
						->first();
				}
			}
		];
	}

	public static function update()
	{
		return [
			'type' => Types::user(),
			'args' => [
				[
					'name' => 'user',
					'description' => 'User to update',
					'type' => new InputObjectType([
						'name' => 'UserInput',
						'fields' => [
							'id' => ['type' => Type::nonNull(Type::string())],
							'is_admin' => ['type' => Type::nonNull(Type::boolean())]
						]
					])
				]
			],
			'resolve' => function ($rootValue, $args) {
                $user = \App\Models\User::find($args['user']['id']);
                if ($user == NULL){
                    //no found
                    return $user;
                }else{
                    $user->is_admin = $args['user']['is_admin'];
                    $user->save();

                    return true;
                }
			}
		];
	}
}