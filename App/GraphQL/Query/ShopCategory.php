<?php

namespace App\GraphQL\Query;

use App\GraphQL\Types;
use Error;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ShopCategory
{
    public static function getMany()
    {
        return [
            'type' => Type::listOf(Types::shopCategoryWithDepth()),
            'description' => 'Get many shop category',
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
                return \App\Models\ShopCategory::query()
                    ->with('items')
                    ->limit($args['limit'])
                    ->orderBy($args['orderBy'], strtolower($args['orderDir']))
                    ->get();
            }
        ];
    }

    public static function getOne()
    {
        return [
            'type' => Types::shopCategoryWithDepth(),
            'description' => 'Get a shop category by id',
            'args' => [
                [
                    'name' => 'id',
                    'description' => 'The Id of the shop category',
                    'type' => Type::string()
                ]
            ],
            'resolve' => function ($rootValue, $args) {
                $item = \App\Models\ShopCategory::with('items')->find($args['id']);
                return $item;
            }
        ];
    }
}