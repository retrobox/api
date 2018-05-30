<?php

namespace App\GraphQL\Type;

use App\GraphQL\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class Genre extends ObjectType
{
	public function __construct()
	{
		$config = [
			'name' => 'Genre',
			'description' => 'The genre of the game (tag)',
			'fields' => [
				'id' => [
					'type' => Type::id()
				],
				'name' => [
					'type' => Type::string()
				],
				'fa_icon' => [
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