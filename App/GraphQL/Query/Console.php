<?php

namespace App\GraphQL\Query;

use App\Auth\Session;
use App\GraphQL\Types;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Psr\Container\ContainerInterface;

class Console
{
    public static function getMany()
    {
        return [
            'type' => Type::listOf(Types::console()),
            'description' => 'Get many consoles',
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
                    'name' => 'all',
                    'description' => 'Fetch all consoles',
                    'type' => Type::boolean(),
                    'defaultValue' => false
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                $session = $container->get(Session::class);
                $query = \App\Models\Console::query()
                    ->with(['user', 'order'])
                    ->limit($args['limit'])
                    ->orderBy($args['orderBy'], strtolower($args['orderDir']));
                if ($args['all']) {
                    if ($session->isAdmin()) {
                        return $query
                            ->get();
                    } else {
                        return new \Exception('Forbidden', 403);
                    }
                } else {
                    return $query
                        ->where('user_id', '=', $session->getUserId())
                        ->get();
                }
            }
        ];
    }

    public static function getOne()
    {
        return [
            'type' => Types::console(),
            'description' => 'Get a console',
            'args' => [
                [
                    'name' => 'id',
                    'description' => 'The Id of the console',
                    'type' => Type::string()
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                $session = $container->get(Session::class);
                $item = \App\Models\Console::with(['user', 'order'])
                    ->find($args['id']);
                if ($item === NULL) {
                    return new \Exception('Unknown shop console', 404);
                }
                if ($session->isAdmin() || $session->getUserId() == $item['user']['id']) {
                    return $item;
                } else {
                    return new \Exception('Forbidden', 403);
                }
            }
        ];
    }

    public static function store()
    {
        return [
            'type' => new ObjectType([
                'name' => 'ConsoleStoreOutput',
                'fields' => [
                    'id' => ['type' => Type::id()],
                    'saved' => ['type' => Type::boolean()]
                ]
            ]),
            'args' => [
                [
                    'name' => 'console',
                    'description' => 'Console to store',
                    'type' => Type::nonNull(new InputObjectType([
                        'name' => 'ConsoleStoreInput',
                        'fields' => [
                            'id' => ['type' => Type::string()],
                            'order_id' => ['type' => Type::string()],
                            'user_id' => ['type' => Type::string()],
                            'color' => ['type' => Type::nonNull(Type::string())],
                            'storage' => ['type' => Type::nonNull(Type::string())]
                        ]
                    ]))
                ]
            ],
            'resolve' => function (ContainerInterface $rootValue, $args) {
                //admin only
                if ($rootValue->get(Session::class)->isAdmin()) {
                    $console = new \App\Models\Console();
                    if (
                        !isset($args['console']['id']) ||
                        $args['console']['id'] == NULL ||
                        empty($args['console']['id'])
                    ) {
                        $console['id'] = self::generateRandom(5);
                    } else {
                        $console['id'] = $args['console']['id'];
                    }
                    $console['token'] = self::generateRandom(32);
                    if (isset($args['console']['user_id'])) {
                        $user = \App\Models\User::query()->find($args['console']['user_id']);
                        if ($user != NULL) {
                            $console->user()->associate($user);
                        } else {
                            return new \Exception('Unknown user', 404);
                        }
                    }
                    if (isset($args['console']['order_id'])) {
                        $order = \App\Models\ShopOrder::query()->find($args['console']['order_id']);
                        if ($order != NULL) {
                            $console->order()->associate($order);
                        } else {
                            return new \Exception('Unknown order', 404);
                        }
                    }
                    $console['color'] = $args['console']['color'];
                    $console['storage'] = $args['console']['storage'];
                    if ($console->save()) {
                        return [
                            'saved' => true,
                            'id' => $console['id']
                        ];
                    } else {
                        return [
                            'saved' => false,
                            'id' => ''
                        ];
                    }
                } else {
                    return new \Exception("Forbidden", 403);
                }
            }
        ];
    }

    private static function generateRandom(int $length): string
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randString = '';
        for ($i = 0; $i < $length; $i++) {
            $randString = $randString . $characters[rand(0, strlen($characters) - 1)];
        }
        return $randString;
    }

    public static function getCount()
    {
        return [
            'type' => Type::int(),
            'description' => 'Get the consoles count',
            'args' => [],
            'resolve' => function (ContainerInterface $container) {
                $session = $container->get(Session::class);
                if ($session->isAdmin()) {
                    return \App\Models\Console::all()->count();
                } else {
                    return new \Exception('Forbidden', 403);
                }
            }
        ];
    }
}