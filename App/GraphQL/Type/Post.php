<?php

namespace App\GraphQL\Type;

use App\GraphQL\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class Post extends ObjectType
{
	public function __construct()
	{
		$config = [
			'name' => 'Post',
			'description' => 'A post in the blog',
			'fields' => [
				'id' => [
					'type' => Type::id()
				],
				'title' => [
					'type' => Type::string()
				],
				'description' => [
					'description' => 'The post description, written in plain text, showed on preview',
					'type' => Type::string()
				],
				'content' => [
					'description' => 'The post body, written in markdown',
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