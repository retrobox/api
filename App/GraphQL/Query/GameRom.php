<?php

namespace App\GraphQL\Query;

use App\Auth\Session;
use App\GraphQL\Types;
use Exception;
use Faker\Provider\Uuid;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Psr\Container\ContainerInterface;

class GameRom
{
    public static function getMany()
    {
        return [
            'type' => Type::listOf(Types::gameRom()),
            'description' => 'Get many GameRom',
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
                if ($container->get(Session::class)->isAdmin()) {
                    return \App\Models\GameRom::query()
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
            'type' => Types::gameRom(),
            'description' => 'Get a game rom by id',
            'args' => [
                [
                    'name' => 'id',
                    'description' => 'The Id of the game rom',
                    'type' => Type::string()
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                if ($container->get(Session::class)->isAdmin()) {
                    $rom = \App\Models\GameRom::query()->find($args['id']);
                    if ($rom == NULL) {
                        return new Exception('Unknown GameRom', 404);
                    } else {
                        return $rom
                            ->first();
                    }
                } else {
                    return new Exception("Forbidden", 403);
                }
            }
        ];
    }

    public static function store()
    {
        return [
            'type' => new ObjectType([
                'name' => 'GameRomStoreOutput',
                'fields' => [
                    'id' => ['type' => Type::id()],
                    'saved' => ['type' => Type::boolean()]
                ]
            ]),
            'args' => [
                [
                    'name' => 'rom',
                    'description' => 'GameRom to store',
                    'type' => Type::nonNull(new InputObjectType([
                        'name' => 'GameRomStoreInput',
                        'fields' => [
                            'url' => ['type' => Type::nonNull(Type::string())],
                            'size' => ['type' => Type::int()],
                            'sha1_hash' => ['type' => Type::string()]
                        ]
                    ]))
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                if ($container->get(Session::class)->isAdmin()) {
                    $rom = new \App\Models\GameRom();
                    $rom['id'] = Uuid::uuid();
                    /** @var $rom \App\Models\GameRom */
                    $rom->setAttributesFromGraphQL($args['rom'], [
                        'url',
                        'size',
                        'sha1_hash'
                    ]);

                    return ['id' => $rom['id'], 'saved' => $rom->save()];
                } else {
                    return new Exception("Forbidden", 403);
                }
            }
        ];
    }

    public static function update()
    {
        return [
            'type' => Type::boolean(),
            'args' => [
                'rom' => [
                    'type' => new InputObjectType([
                        'name' => 'GameRomUpdateInput',
                        'fields' => [
                            'id' => Type::id(),
                            'url' => ['type' => Type::nonNull(Type::string())],
                            'size' => ['type' => Type::int()],
                            'sha1_hash' => ['type' => Type::string()]
                        ]
                    ])
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                if ($container->get(Session::class)->isAdmin()) {
                    $rom = \App\Models\GameRom::query()->find($args['rom']['id']);
                    if ($rom == NULL){
                        return new Exception('Unknown GameRom', 404);
                    }
                    /** @var $rom \App\Models\GameRom */
                    $rom->setAttributesFromGraphQL($args['rom'], [
                        'url',
                        'size',
                        'sha1_hash'
                    ]);
                    return $rom->save();
                } else {
                    return new Exception('Forbidden', 403);
                }
            }
        ];
    }

    public static function destroy()
    {
        return [
            'type' => Type::boolean(),
            'args' => [
                'id' => [
                    'type' => Type::id()
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                if ($container->get(Session::class)->isAdmin()) {
                    $rom = \App\Models\GameRom::query()->find($args['id']);
                    if ($rom == NULL){
                        return new Exception('Unknown GameRom', 404);
                    }
                    return \App\Models\GameRom::destroy($rom['id']);
                } else {
                    return new Exception('Forbidden', 403);
                }
            }
        ];
    }
}
