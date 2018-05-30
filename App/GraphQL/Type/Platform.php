<?php

namespace App\GraphQL\Type;

use App\GraphQL\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class Platform extends ObjectType
{
	public function __construct()
	{
		$config = [
			'name' => 'Platform',
			'description' => 'The platform which run the retrogame',
			'fields' => [
				'id' => [
					'type' => Type::id()
				],
				'name' => [
					'type' => Type::string()
				],
				'short' => [
					'type' => Type::string()
				],
				'description' => [
					'type' => Type::string()
				],
				'manufacturer' => [
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