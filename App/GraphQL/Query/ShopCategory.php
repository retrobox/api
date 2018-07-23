<?php

namespace App\GraphQL\Query;

use App\Auth\Session;
use App\GraphQL\Types;
use Error;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Psr\Container\ContainerInterface;

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
                    'defaultValue' => NULL
                ],
            ],
            'resolve' => function ($rootValue, $args) {
                $query = \App\Models\ShopCategory::query()
                    ->with('items')
                    ->limit($args['limit'])
                    ->orderBy($args['orderBy'], strtolower($args['orderDir']));

                if ($args['locale'] != NULL){
                    $query
                        ->where('locale', '=', $args['locale']);
                }

                return $query->get();
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
                    'id' => ['type' => Type::id()],
                    'saved' => ['type' => Type::boolean()]
                ]
            ]),
            'args' => [
                [
                    'name' => 'category',
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
            'resolve' => function (ContainerInterface $rootValue, $args) {
                //admin only
                if ($rootValue->get(Session::class)->isAdmin()){
                    $item = new \App\Models\ShopCategory();
                    $item->id = uniqid();
                    $item->title = $args['category']['title'];
                    $item->is_customizable = $args['category']['is_customizable'];
                    $item->locale = $args['category']['locale'];
                    if ($item->save()){
                        return [
                            'saved' => true,
                            'id' => $item->id
                        ];
                    }else{
                        return NULL;
                    }
                }else{
                    return new \Exception("Forbidden", 403);
                }
            }
        ];
    }

    public static function  update()
    {
        return [
            'type' => Type::boolean(),
            'args' => [
                [
                    'name' => 'category',
                    'description' => 'Category to update',
                    'type' => new InputObjectType([
                        'name' => 'ShopCategoryUpdateInput',
                        'fields' => [
                            'id' => ['type' => Type::nonNull(Type::string())],
                            'title' => ['type' => Type::nonNull(Type::string())],
                            'is_customizable' => ['type' => Type::nonNull(Type::boolean())],
                            'locale' => ['type' => Type::nonNull(Type::string())]
                        ]
                    ])
                ]
            ],
            'resolve' => function ($rootValue, $args) {
                //admin only
                if ($rootValue->get(Session::class)->isAdmin()){
                    $item = \App\Models\ShopCategory::with('items')->find($args['category']['id']);
                    if ($item == NULL){
                        return new \Exception("ShopCategory not found", 404);
                    }else{
                        $item->title = $args['category']['title'];
                        $item->is_customizable = $args['category']['is_customizable'];
                        $item->locale = $args['category']['locale'];
                        return $item->save();
                    }
                }else{
                    return new \Exception("Forbidden", 403);
                }
            }
        ];
    }

    public static function destroy()
    {
        return [
            'type' => Type::boolean(),
            'description' => 'Destroy a shop category',
            'args' => [
                [
                    'name' => 'id',
                    'description' => 'The Id of the shop category to destroy',
                    'type' => Type::string()
                ]
            ],
            'resolve' => function ($rootValue, $args) {
                //only admin
                if ($rootValue->get(Session::class)->isAdmin()){
                    $item = \App\Models\ShopCategory::find($args['id']);
                    if ($item == NULL){
                        return new \Exception("ShopCategory not found", 404);
                    }else{
                        return \App\Models\ShopCategory::destroy($args['id']);
                    }
                }else{
                    return new \Exception("Forbidden", 403);
                }
            }
        ];
    }
}