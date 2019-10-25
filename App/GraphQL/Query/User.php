<?php

namespace App\GraphQL\Query;

use App\Auth\Session;
use App\GraphQL\Types;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;
use Psr\Container\ContainerInterface;

class User
{
    public static function getMany()
    {
        return [
            'type' => Type::listOf(Types::user()),
            'description' => 'Get many users',
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
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                //admin only
                if ($container->get(Session::class)->isAdmin()) {
                    return \App\Models\User::query()
                        ->limit($args['limit'])
                        ->orderBy($args['orderBy'], strtolower($args['orderDir']))
                        ->get();
                } else {
                    return new \Exception("Forbidden", 403);
                }
            }
        ];
    }

    public static function getOne()
    {
        return [
            'type' => Types::user(),
            'description' => 'Get a user by id',
            'args' => [
                [
                    'name' => 'id',
                    'description' => 'The STAIL.EU uuid of the user account',
                    'type' => Type::string(),
                    'defaultValue' => NULL
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                $userId = $container->get(Session::class)->getUserId();
                if ($args['id'] === NULL) {
                    $user = \App\Models\User::query()->find($userId);
                } else {
                    $user = \App\Models\User::query()->find($args['id']);
                }
                if ($user == NULL) {
                    return new \Exception('Unknown user', 404);
                }
                if ($container->get(Session::class)->isAdmin() === false &&
                    $user->id !== $userId) {
                    return new \Exception('Forbidden user', 403);
                }

                return $user;
            }
        ];
    }

    public static function update()
    {
        return [
            'type' => Type::boolean(),
            'args' => [
                [
                    'name' => 'user',
                    'description' => 'User to update',
                    'type' => new InputObjectType([
                        'name' => 'UserUpdateInput',
                        'fields' => [
                            'id' => ['type' => Type::nonNull(Type::string())],
                            'is_admin' => ['type' => Type::boolean()],
                            'first_name' => ['type' => Type::string()],
                            'last_name' => ['type' => Type::string()],
                            'address_first_line' => ['type' => Type::string()],
                            'address_second_line' => ['type' => Type::string()],
                            'address_postal_code' => ['type' => Type::string()],
                            'address_city' => ['type' => Type::string()],
                            'address_country' => ['type' => Type::string()]
                        ]
                    ])
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                $user = \App\Models\User::query()->find($args['user']['id']);
                if ($user == NULL) {
                    return new \Exception('Unknown user', 404);
                }
                if (isset($args['user']['first_name'])) {
                    $user->first_name = $args['user']['first_name'];
                }
                if (isset($args['user']['last_name'])) {
                    $user->last_name = $args['user']['last_name'];
                }
                if (isset($args['user']['address_first_line'])) {
                    $user->address_first_line = $args['user']['address_first_line'];
                }
                if (isset($args['user']['address_second_line'])) {
                    $user->address_second_line = $args['user']['address_second_line'];
                }
                if (isset($args['user']['address_postal_code'])) {
                    $user->address_postal_code = $args['user']['address_postal_code'];
                }
                if (isset($args['user']['address_city'])) {
                    $user->address_city = $args['user']['address_city'];
                }
                if (isset($args['user']['address_country'])) {
                    $user->address_country = $args['user']['address_country'];
                }
                if (isset($args['user']['is_admin'])) {
                    $user->is_admin = $args['user']['is_admin'];
                }
                return $user->save();
            }
        ];
    }

    public static function destroy() {
        return [
            'type' => Type::boolean(),
            'args' => [
                'id' => [
                    'type' => Type::id()
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                if ($container->get(Session::class)->isAdmin()) {
                    $user = \App\Models\User::query()->find($args['id']);
                    if ($user == NULL){
                        return new \Exception('Unknown User', 404);
                    }
                    return \App\Models\User::destroy($user['id']);
                } else {
                    return new \Exception('Forbidden', 403);
                }
            }
        ];
    }

}
