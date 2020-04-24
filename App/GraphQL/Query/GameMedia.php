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

class GameMedia
{
    public static function getMany()
    {
        return [
            'type' => Type::listOf(Types::gameMedia()),
            'description' => 'Get many GameMedias',
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
                    return \App\Models\GameMedia::query()
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
            'type' => Types::gameMedia(),
            'description' => 'Get a game media by id',
            'args' => [
                [
                    'name' => 'id',
                    'description' => 'The Id of the game media',
                    'type' => Type::string()
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                if ($container->get(Session::class)->isAdmin()) {
                    $media = \App\Models\GameMedia::query()->find($args['id']);
                    if ($media == NULL) {
                        return new Exception('Unknown GameMedia', 404);
                    } else {
                        return $media
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
                'name' => 'GameMediaStoreOutput',
                'fields' => [
                    'id' => ['type' => Type::id()],
                    'saved' => ['type' => Type::boolean()]
                ]
            ]),
            'args' => [
                [
                    'name' => 'media',
                    'description' => 'GameMedia to store',
                    'type' => Type::nonNull(new InputObjectType([
                        'name' => 'GameMediaStoreInput',
                        'fields' => [
                            'url' => ['type' => Type::nonNull(Type::string())],
                            'type' => ['type' => Type::nonNull(Type::string())],
                            'is_main' => ['type' => Type::boolean()]
                        ]
                    ]))
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                if ($container->get(Session::class)->isAdmin()) {
                    $media = new \App\Models\GameMedia();
                    $media['id'] = Uuid::uuid();
                    /** @var $media \App\Models\GameMedia */
                    $media->setAttributesFromGraphQL($args['media'], [
                        'url',
                        'type',
                        'is_main'
                    ]);

                    return ['id' => $media['id'], 'saved' => $media->save()];
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
                'media' => [
                    'type' => new InputObjectType([
                        'name' => 'GameMediaUpdateInput',
                        'fields' => [
                            'id' => Type::id(),
                            'url' => ['type' => Type::nonNull(Type::string())],
                            'type' => ['type' => Type::nonNull(Type::string())],
                            'is_main' => ['type' => Type::boolean()]
                        ]
                    ])
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                if ($container->get(Session::class)->isAdmin()) {
                    $media = \App\Models\GameMedia::query()->find($args['media']['id']);
                    if ($media == NULL){
                        return new Exception('Unknown GameMedia', 404);
                    }
                    /** @var $media \App\Models\GameMedia */
                    $media->setAttributesFromGraphQL($args['media'], [
                        'url',
                        'type',
                        'is_main'
                    ]);
                    return $media->save();
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
                    $editor = \App\Models\GameMedia::query()->find($args['id']);
                    if ($editor == NULL){
                        return new Exception('Unknown GameMedia', 404);
                    }
                    return \App\Models\GameMedia::destroy($editor['id']);
                } else {
                    return new Exception('Forbidden', 403);
                }
            }
        ];
    }
}
