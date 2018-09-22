<?php

namespace App\GraphQL\Query;

use App\Auth\Session;
use App\GraphQL\Types;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;
use Psr\Container\ContainerInterface;

class ShopOrder
{
    public static function getMany()
    {
        return [
            'type' => Type::listOf(Types::shopOrderWithDepth()),
            'description' => 'Get many shop order',
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
            'resolve' => function (ContainerInterface $container, $args) {
                if ($container->get(Session::class)->isAdmin()) {
                    return \App\Models\ShopOrder::query()
                        ->with(['user', 'items'])
                        ->limit($args['limit'])
                        ->orderBy($args['orderBy'], strtolower($args['orderDir']))
                        ->get();
                } else {
                    return new \Exception('Forbidden', 403);
                }
            }
        ];
    }

    public static function getOne()
    {
        return [
            'type' => Types::shopOrderWithDepth(),
            'description' => 'Get a shop order',
            'args' => [
                [
                    'name' => 'id',
                    'description' => 'The Id of the shop order',
                    'type' => Type::string()
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                if ($container->get(Session::class)->isAdmin()) {
                    $item = \App\Models\ShopOrder::with(['user', 'items'])->find($args['id']);
                    if ($item === NULL) {
                        return new \Exception('Unknown shop order', 404);
                    }
                    return $item;
                } else {
                    return new \Exception('Forbidden', 403);
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
                    'name' => 'order',
                    'description' => 'Order to update',
                    'type' => new InputObjectType([
                        'name' => 'ShopOrderUpdateInput',
                        'fields' => [
                            'id' => ['type' => Type::nonNull(Type::string())],
                            'status' => ['type' => Type::string()],
                            'bill_url' => ['type' => Type::string()]
                        ]
                    ])
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                if ($container->get(Session::class)->isAdmin()) {
                    $order = \App\Models\ShopOrder::query()->find($args['order']['id']);
                    if ($order == NULL) {
                        return new \Exception("Unknown ShopOrder", 404);
                    } else {
                        if (isset($args['order']['status'])) {
                            $order->status = $args['order']['status'];
                        }
                        if (isset($args['order']['bill_url'])) {
                            $order->bill_url = $args['order']['bill_url'];
                        }

                        return $order->save();
                    }
                } else {
                    return new \Exception("Forbidden", 403);
                }
            }
        ];
    }
}