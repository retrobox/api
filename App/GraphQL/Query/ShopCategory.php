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
                ],
                [
                    'name' => 'locale',
                    'description' => 'Filter by locales',
                    'type' => Type::string(),
                    'defaultValue' => 'fr'
                ],
            ],
            'resolve' => function ($rootValue, $args) {
                return \App\Models\ShopCategory::query()
                    ->with('items')
                    ->limit($args['limit'])
                    ->orderBy($args['orderBy'], strtolower($args['orderDir']))
                    ->where('locale', '=', $args['locale'])
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

    public static function store()
    {
        return [
            'type' => new ObjectType([
                'name' => 'ShopCategoryStoreOutput',
                'fields' => [
                    [
                        'name' => 'success',
                        'type' => Type::boolean()
                    ],
                    [
                        'name' => 'id',
                        'type' => Type::id()
                    ]
                ]
            ]),
            'args' => [
                [
                    'name' => 'item',
                    'description' => 'Category to store',
                    'type' => new InputObjectType([
                        'name' => 'ShopCategoryStoreInput',
                        'fields' => [
                            'title' => ['type' => Type::nonNull(Type::string())],
                            'is_customizable' => ['type' => Type::nonNull(Type::boolean())],
                            'locale' => ['type' => Type::nonNull(Type::string())]
                        ]
                    ])
                ]
            ],
            'resolve' => function ($rootValue, $args) {
                //verify if the category exist
                $item = new \App\Models\ShopCategory();
                $item->id = uniqid();
                $item->title = $args['item']['title'];
                $item->is_customizable = $args['item']['is_customizable'];
                $item->locale = $args['item']['locale'];
                $item->save();
                return $item;
            }
        ];
    }

    public static function update()
    {
        return [
            'type' => Type::boolean(),
            'args' => [
                [
                    'name' => 'item',
                    'description' => 'Category to update',
                    'type' => new InputObjectType([
                        'name' => 'ShopCategoryUpdateInput',
                        'fields' => [
                            'title' => ['type' => Type::nonNull(Type::string())],
                            'is_customizable' => ['type' => Type::nonNull(Type::boolean())],
                            'locale' => ['type' => Type::nonNull(Type::string())]
                        ]
                    ])
                ]
            ],
            'resolve' => function ($rootValue, $args) {
                //verify if the category exist
                $item = new \App\Models\ShopCategory();
                $item->id = uniqid();
                $item->title = $args['item']['title'];
                $item->is_customizable = $args['item']['is_customizable'];
                $item->locale = $args['item']['locale'];
                $item->save();
                return $item;
            }
        ];
    }
}