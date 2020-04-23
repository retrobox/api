<?php

namespace App\GraphQL\Query;

use App\Auth\Session;
use App\GraphQL\Types;
use App\Models\ShopCategory;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Str;

class ShopItem
{
    public static function getMany()
    {
        return [
            'type' => Type::listOf(Types::shopItem()),
            'description' => 'Get many shop item',
            'args' => [
                [
                    'name' => 'limit',
                    'description' => 'Number of items to get',
                    'type' => Type::int(),
                    'defaultValue' => -1
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
                ]
            ],
            'resolve' => function ($rootValue, $args) {
                return \App\Models\ShopItem::query()
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
            'type' => Types::shopItemWithDepth(),
            'description' => 'Get a shop item by id',
            'args' => [
                [
                    'name' => 'id',
                    'description' => 'The Id of the shop item',
                    'type' => Type::string()
                ],
                [
                    'name' => 'slug',
                    'description' => 'The Slug of the shop item',
                    'type' => Type::string()
                ]
            ],
            'resolve' => function ($rootValue, $args) {
                if (isset($args['id'])) {
                    $item = \App\Models\ShopItem::with(['category', 'images'])->find($args['id']);
                } elseif (isset($args['slug'])) {
                    $item = \App\Models\ShopItem::query()->where('slug', '=', $args['slug'])->with(['category', 'images'])->first();
                } else {
                    $item = \App\Models\ShopItem::find($args['id']);
                }

                return $item;
            }
        ];
    }

    public static function store()
    {
        return [
            'type' => new ObjectType([
                'name' => 'ShopItemStoreOutput',
                'fields' => [
                    'id' => ['type' => Type::id()],
                    'saved' => ['type' => Type::boolean()]
                ]
            ]),
            'args' => [
                [
                    'name' => 'item',
                    'description' => 'Item to store',
                    'type' => new InputObjectType([
                        'name' => 'ShopItemStoreInput',
                        'fields' => [
                            'title' => ['type' => Type::nonNull(Type::string())],
                            'identifier' => ['type' => Type::nonNull(Type::string())],
                            'description_short' => ['type' => Type::nonNull(Type::string())],
                            'description_long' => ['type' => Type::nonNull(Type::string())],
                            'show_version' => ['type' => Type::nonNull(Type::boolean())],
                            'price' => ['type' => Type::nonNull(Types::float())],
                            'weight' => ['type' => Type::nonNull(Types::float())],
                            'image' => ['type' => Type::nonNull(Types::url())],
                            'version' => ['type' => Type::string()],
                            'allow_indexing' => ['type' => Type::boolean(), 'default' => false],
                            'category_id' => ['type' => Type::nonNull(Type::string())],
                            'images' => ['type' => Type::listOf(new InputObjectType([
                                'name' => 'ShopImageStoreInput',
                                'fields' => [
                                    'url' => ['type' => Type::nonNull(Types::url())],
                                    'is_main' => ['type' => Type::nonNull(Type::boolean())]
                                ]
                            ]))]
                        ]
                    ])
                ]
            ],
            'resolve' => function ($rootValue, $args) {
                //admin only
                if ($rootValue->get(Session::class)->isAdmin()) {
                    //verify if the category exist
                    $item = new \App\Models\ShopItem();
                    $item->id = uniqid();
                    $category = ShopCategory::find($args['item']['category_id']);
                    if ($category !== NULL) {
                        $item->category()->associate($category);
                    } else {
                        return new \Exception('Unknown category', 404);
                    }
                    $images = array_map(function ($image){
                        $image['id'] = uniqid();
                        return $image;
                    }, $args['item']['images']);
                    $item->images()->createMany(
                        $images
                    );
                    $item->title = $args['item']['title'];
                    $item->identifier = $args['item']['identifier'];
                    $item->locale = $category->locale;
                    $item->description_short = $args['item']['description_short'];
                    $item->description_long = $args['item']['description_long'];
                    $item->version = $args['item']['version'];
                    $item->show_version = $args['item']['show_version'];
                    $item->image = $args['item']['image'];
                    $item->price = (float) $args['item']['price'];
                    $item->weight = (float) $args['item']['weight'];
                    $item->slug = Str::slug($args['item']['identifier']);
                    $item->allow_indexing = $args['item']['allow_indexing'];

                    return [
                        'saved' => $item->save(),
                        'id' => $item->id
                    ];
                } else {
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
                    'name' => 'item',
                    'description' => 'Item to update',
                    'type' => new InputObjectType([
                        'name' => 'ShopItemUpdateInput',
                        'fields' => [
                            'id' => ['type' => Type::nonNull(Type::string())],
                            'title' => ['type' => Type::nonNull(Type::string())],
                            'description_short' => ['type' => Type::nonNull(Type::string())],
                            'description_long' => ['type' => Type::nonNull(Type::string())],
                            'show_version' => ['type' => Type::nonNull(Type::boolean())],
                            'price' => ['type' => Type::nonNull(Types::float())],
                            'identifier' => ['type' => Type::nonNull(Type::string())],
                            'weight' => ['type' => Type::nonNull(Types::float())],
                            'image' => ['type' => Type::nonNull(Type::string())],
                            'version' => ['type' => Type::string()],
                            'allow_indexing' => ['type' => Type::boolean(), 'default' => null],
                            'category_id' => ['type' => Type::nonNull(Type::string())],
                            'images' => ['type' => Type::listOf(new InputObjectType([
                                'name' => 'ShopImageUpdateInput',
                                'fields' => [
                                    'url' => ['type' => Type::nonNull(Types::url())],
                                    'is_main' => ['type' => Type::nonNull(Type::boolean())]
                                ]
                            ]))]
                        ]
                    ])
                ]
            ],
            'resolve' => function ($rootValue, $args) {
                //admin only
                if ($rootValue->get(Session::class)->isAdmin()) {
                    $item = \App\Models\ShopItem::with('images', 'category')->find($args['item']['id']);
                    if ($item == NULL) {
                        return new \Exception("Unknown ShopItem", 404);
                    } else {
                        $category = ShopCategory::find($args['item']['category_id']);
                        if ($category !== NULL) {
                            $item->category()->dissociate();
                            $item->category()->associate($category);
                        } else {
                            return new \Exception('Unknown category', 404);
                        }
                        //delete all images
                        //and reinsert it
                        $item->images()->delete();
                        $images = array_map(function ($image){
                            $image['id'] = uniqid();
                            return $image;
                        }, $args['item']['images']);
                        $item->images()->createMany(
                            $images
                        );
                        $item->title = $args['item']['title'];
                        $item->identifier = $args['item']['identifier'];
                        $item->locale = $category->locale;
                        $item->description_short = $args['item']['description_short'];
                        $item->description_long = $args['item']['description_long'];
                        $item->version = $args['item']['version'];
                        $item->show_version = $args['item']['show_version'];
                        $item->image = $args['item']['image'];
                        $item->price = (float) $args['item']['price'];
                        $item->weight = (float) $args['item']['weight'];
                        $item->slug = Str::slug($args['item']['identifier']);
                        $item->allow_indexing = $args['item']['allow_indexing'] === NULL ? $item['allow_indexing'] : $args['item']['allow_indexing'];

                        return $item->save();
                    }
                } else {
                    return new \Exception("Forbidden", 403);
                }
            }
        ];
    }

    public static function destroy()
    {
        return [
            'type' => Type::boolean(),
            'description' => 'Destroy a shop item',
            'args' => [
                [
                    'name' => 'id',
                    'description' => 'The Id of the shop item to destroy',
                    'type' => Type::string()
                ]
            ],
            'resolve' => function ($rootValue, $args) {
                //only admin
                if ($rootValue->get(Session::class)->isAdmin()) {
                    $item = \App\Models\ShopItem::find($args['id']);
                    if ($item == NULL) {
                        return new \Exception("ShopItem not found", 404);
                    } else {
                        return \App\Models\ShopItem::destroy($args['id']);
                    }
                } else {
                    return new \Exception("Forbidden", 403);
                }
            }
        ];
    }
}
