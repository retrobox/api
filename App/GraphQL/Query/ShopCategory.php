<?php

namespace App\GraphQL\Query;

use App\Auth\Session;
use App\GraphQL\Types;
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
                    ->withCount('items')
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
                $item = \App\Models\ShopCategory::withCount('items')->find($args['id']);
                if ($item == NULL){
                    return new \Exception("ShopCategory not found", 404);
                }else{
                    return $item;
                }
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
                    //take by default the order in the bottom
                    // TODO: Take by default the last order (so we will have to fetch all the orders value to see the highest and compute from that)
                    $item->order = 0;
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

    public static function update()
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
                            'title' => ['type' => Type::string()],
                            'is_customizable' => ['type' => Type::boolean()],
                            'locale' => ['type' => Type::string()],
                            'order' => ['type' => Type::int()]
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
                        if(isset($args['category']['title'])
                            && !empty($args['category']['title'])){
                            $item->title = $args['category']['title'];
                        }
                        if(isset($args['category']['is_customizable'])
                            && !empty($args['category']['is_customizable'])){
                            $item->is_customizable = $args['category']['is_customizable'];
                        }
                        if(isset($args['category']['is_customizable'])
                            && !empty($args['category']['is_customizable'])){
                            $item->is_customizable = $args['category']['is_customizable'];
                        }
                        if(isset($args['category']['locale'])){
                            $item->locale = $args['category']['locale'];
                        }
                        if(isset($args['category']['order'])){
                            $item->order = $args['category']['order'];
                        }
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
                    // TODO: Re Order the categories to do something that make sense
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

    public static function updateOrder()
    {
        return [
            'type' => Type::boolean(),
            'description' => 'Update the shop categories order',
            'args' => [
                [
                    'name' => 'categories',
                    'description' => 'List of categories',
                    'type' => Type::listOf(new InputObjectType([
                        'name' => 'ShopCategoryUpdateOrderInput',
                        'fields' => [
                            'id' => Type::string(),
                            'order' => Type::int()
                        ]
                    ]))
                ]
            ],
            'resolve' => function ($rootValue, $args) {
                //only admin
                if ($rootValue->get(Session::class)->isAdmin()){
                    foreach ($args['categories'] as $category){
                        $item = \App\Models\ShopCategory::find($category['id']);
                        if ($item == NULL){
                            return new \Exception("ShopCategory not found", 404);
                        }else{
                            $item->order = $category['order'];
                            if (!$item->save()){
                                return false;
                            }
                        }
                    }
                    return true;
                }else{
                    return new \Exception("Forbidden", 403);
                }
            }
        ];
    }
}