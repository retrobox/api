<?php

namespace App\GraphQL\Type;

use App\GraphQL\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ShopItem extends ObjectType
{
    public function __construct($depth = false)
    {
        if ($depth) {
            $depthArray = [
                'category' => [
                    'type' => Types::shopCategoryWithDepth()
                ],
                'pivot' => [
                    'type' => new ObjectType([
                        'name' => 'PivotOutput',
                        'fields' => [
                            'shop_item_custom_option_storage' => [
                                'type' => Type::string()
                            ],
                            'shop_item_custom_option_color' => [
                                'type' => Type::string()
                            ]
                        ]
                    ])
                ]
            ];
            $name = "ShopItemWithDepth";
        } else {
            $name = "ShopItem";
            $depthArray = [];
        }
        $config = [
            'name' => $name,
            'description' => 'A item in the shop',
            'fields' => array_merge([
                'id' => [
                    'type' => Type::id()
                ],
                'title' => [
                    'type' => Type::string()
                ],
                'image' => [
                    'type' => Type::string()
                ],
                'identifier' => [
                    'description' => "Identifier is used to identify the same product in two different locale",
                    'type' => Type::string()
                ],
                'slug' => [
                    'description' => "Generated on identifier",
                    'type' => Type::string()
                ],
                'weight' => [
                    'description' => 'Weight of the item in g SI',
                    'type' => Type::float()
                ],
                'images' => [
                    'description' => 'Images belongs to this shop item',
                    'type' => Type::listOf(Types::shopImage())
                ],
                'description_short' => [
                    'type' => Type::string()
                ],
                'description_long' => [
                    'description' => "Written in markdown",
                    'type' => Type::string()
                ],
                'price' => [
                    'type' => Type::float()
                ],
                'version' => [
                    'type' => Type::string()
                ],
                'locale' => [
                    'type' => Type::string()
                ],
                'show_version' => [
                    'type' => Type::boolean()
                ],
                'created_at' => [
                    'type' => Types::dateTime()
                ],
                'updated_at' => [
                    'type' => Types::dateTime()
                ]
            ], $depthArray)
        ];

        parent::__construct($config);
    }
}