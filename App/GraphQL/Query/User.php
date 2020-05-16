<?php

namespace App\GraphQL\Query;

use App\Auth\Session;
use App\GraphQL\Types;
use App\Utils\Countries;
use Exception;
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
            'args' => [[
                'name' => 'limit',
                'description' => 'Number of items to get',
                'type' => Type::int(),
                'defaultValue' => -1
            ], [
                'name' => 'orderBy',
                'description' => 'Order by a field',
                'type' => Type::string(),
                'defaultValue' => 'created_at'
            ], [
                'name' => 'orderDir',
                'description' => 'Direction of the order',
                'type' => Type::string(),
                'defaultValue' => 'desc'
            ]],
            'resolve' => function (ContainerInterface $container, $args) {
                //admin only
                if ($container->get(Session::class)->isAdmin()) {
                    return \App\Models\User::query()
                        ->limit($args['limit'])
                        ->orderBy($args['orderBy'], strtolower($args['orderDir']))
                        ->get();
                } else {
                    return new Exception("Forbidden", 403);
                }
            }
        ];
    }

    public static function getOne()
    {
        return [
            'type' => Types::user(),
            'description' => 'Get a user by id',
            'args' => [[
                'name' => 'id',
                'description' => 'The STAIL.EU uuid of the user account',
                'type' => Type::string(),
                'defaultValue' => NULL
            ]],
            'resolve' => function (ContainerInterface $container, $args) {
                $userId = $container->get(Session::class)->getUserId();
                if ($args['id'] === NULL) {
                    $user = \App\Models\User::query()->find($userId);
                } else {
                    $user = \App\Models\User::query()->find($args['id']);
                }
                if ($user == NULL) {
                    return new Exception('Unknown user', 404);
                }
                if ($container->get(Session::class)->isAdmin() === false && $user['id'] !== $userId) {
                    return new Exception('Forbidden user', 403);
                }

                return $user;
            }
        ];
    }

    public static function update()
    {
        return [
            'type' => Type::boolean(),
            'args' => [[
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
            ]],
            'resolve' => function (ContainerInterface $container, $args) {
                $session = $container->get(Session::class);
                /* @var $user \App\Models\User */
                $user = \App\Models\User::query()->find($args['user']['id']);
                if (!$session->isAdmin() && $session->getUserId() !== $args['user']['id']) {
                    return new Exception('Forbidden', 403);
                }
                if ($user == NULL) {
                    return new Exception('Unknown user', 404);
                }
                $countriesHelper = $container->get(Countries::class);
                if (
                    isset($args['user']['address_country']) &&
                    !$countriesHelper->isCountryCodeValid($args['user']['address_country'])
                )
                    return new Exception('Invalid country code', 400);
                $user->setAttributesFromGraphQL($args['user'], [
                    'first_name',
                    'last_name',
                    'address_first_line',
                    'address_second_line',
                    'address_postal_code',
                    'address_city',
                    'address_country'
                ]);
                if (isset($args['user']['is_admin']) && is_bool($args['user']['is_admin'])) {
                    if (!$session->isAdmin()) {
                        return new Exception('Forbidden, you must be a admin to change user admin level', 403);
                    }
                    $user['is_admin'] = $args['user']['is_admin'];
                }
                return $user->save();
            }
        ];
    }

    public static function destroy()
    {
        return [
            'type' => Type::boolean(),
            'args' => ['id' => ['type' => Type::id()]],
            'resolve' => function (ContainerInterface $container, $args) {
                $session = $container->get(Session::class);
                if ($session->isAdmin() || $session->getUserId() === $args['id']) {
                    $user = \App\Models\User::query()->find($args['id']);
                    if ($user == NULL) {
                        return new Exception('Unknown User', 404);
                    }
                    return \App\Models\User::destroy($user['id']);
                } else {
                    return new Exception('Forbidden', 403);
                }
            }
        ];
    }

}
