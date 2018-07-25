<?php

namespace App\GraphQL\Query;

use App\Auth\Session;
use App\GraphQL\Types;
use App\Models\ShopCategory;
use Error;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ShopImage
{

    public static function destroy()
    {
        return [
            'type' => Type::boolean(),
            'description' => 'Destroy a shop image',
            'args' => [
                [
                    'name' => 'id',
                    'description' => 'The Id of the shop image to destroy',
                    'type' => Type::string()
                ]
            ],
            'resolve' => function ($rootValue, $args) {
                //only admin
                if ($rootValue->get(Session::class)->isAdmin()) {
                    $item = \App\Models\ShopImage::find($args['id']);
                    if ($item == NULL) {
                        return new \Exception("Unknown ShopImage", 404);
                    } else {
                        return \App\Models\ShopImage::destroy($args['id']);
                    }
                } else {
                    return new \Exception("Forbidden", 403);
                }
            }
        ];
    }
}