<?php

namespace App\GraphQL\Query;

use App\Auth\Session;
use Exception;
use GraphQL\Type\Definition\Type;
use Psr\Container\ContainerInterface;

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
            'resolve' => function (ContainerInterface $container, $args) {
                //only admin
                if ($container->get(Session::class)->isAdmin()) {
                    $item = \App\Models\ShopImage::query()->find($args['id']);
                    if ($item == NULL) {
                        return new Exception("Unknown ShopImage", 404);
                    } else {
                        return \App\Models\ShopImage::destroy($args['id']);
                    }
                } else {
                    return new Exception("Forbidden", 403);
                }
            }
        ];
    }
}