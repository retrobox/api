<?php

namespace App\GraphQL\Query;

use App\Auth\Session;
use App\GraphQL\Types;
use Faker\Provider\Uuid;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Psr\Container\ContainerInterface;

class GamePlatform
{
    public static function getMany()
    {
        return [
            'type' => Type::listOf(Types::gamePlatform()),
            'description' => 'Get many GamePlatform',
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
                return \App\Models\GamePlatform::query()
                    ->withCount('games', 'medias')
                    ->limit($args['limit'])
                    ->orderBy($args['orderBy'], strtolower($args['orderDir']))
                    ->get();
            }
        ];
    }

    public static function getOne()
    {
        return [
            'type' => Types::gamePlatformWithDepth(),
            'description' => 'Get a platform by id',
            'args' => [
                [
                    'name' => 'id',
                    'description' => 'The Id of the game platform',
                    'type' => Type::string()
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                $platform = \App\Models\GamePlatform::query()->find($args['id']);
                if ($platform == NULL) {
                    return new \Exception('Unknown GamePlatform', 404);
                } else {
                    return $platform
                        ->with('games', 'medias')
                        ->first();
                }
            }
        ];
    }

    public static function store()
    {
        return [
            'type' => new ObjectType([
                'name' => 'GamePlatformStoreOutput',
                'fields' => [
                    'id' => ['type' => Type::id()],
                    'saved' => ['type' => Type::boolean()]
                ]
            ]),
            'args' => [
                [
                    'name' => 'platform',
                    'description' => 'GamePlatform to store',
                    'type' => Type::nonNull(new InputObjectType([
                        'name' => 'GamePlatformStoreInput',
                        'fields' => [
                            'name' => ['type' => Type::nonNull(Type::string())],
                            'description' => ['type' => Type::nonNull(Type::string())],
                            'short' => ['type' => Type::string()],
                            'manufacturer' => ['type' => Type::string()],
                            'cpu' => ['type' => Type::string()],
                            'memory' => ['type' => Type::string()],
                            'graphics' => ['type' => Type::string()],
                            'sound' => ['type' => Type::string()],
                            'display' => ['type' => Type::string()],
                            'max_controllers' => ['type' => Type::int()],
                            'thegamesdb_rating' => ['type' => Type::float()],
                            'released_at' => ['type' => Types::dateTime()],
                            'medias' => ['type' => Type::listOf(Type::id())]
                        ]
                    ]))
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                if ($container->get(Session::class)->isAdmin()) {
                    $platform = new \App\Models\GamePlatform();
                    $platform['id'] = Uuid::uuid();
                    $platform->setAttributesFromGraphQL($args['platform'], [
                        'name',
                        'description',
                        'short',
                        'manufacturer',
                        'cpu',
                        'memory',
                        'graphics',
                        'sound',
                        'display',
                        'media',
                        'max_controllers',
                        'thegamesdb_rating',
                        'released_at'
                    ]);


                    if (isset($args['platform']['medias'])) {
                        foreach ($args['platform']['medias'] as $mediaId) {
                            /** @var $media \App\Models\GameMedia */
                            $media = \App\Models\GameMedia::query()->find($mediaId);
                            if ($media != NULL) {
                                $media['platform_id'] = $platform['id'];
                                $media->save();
                            } else {
                                new \Exception("Unknown media '{$media}'", 404);
                            }
                        }
                    }

                    return ['id' => $platform['id'], 'saved' => $platform->save()];
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
                'platform' => [
                    'type' => new InputObjectType([
                        'name' => 'GamePlatformUpdateInput',
                        'fields' => [
                            'id' => Type::nonNull(Type::id()),
                            'name' => ['type' => Type::nonNull(Type::string())],
                            'description' => ['type' => Type::nonNull(Type::string())],
                            'short' => ['type' => Type::string()],
                            'manufacturer' => ['type' => Type::string()],
                            'cpu' => ['type' => Type::string()],
                            'memory' => ['type' => Type::string()],
                            'graphics' => ['type' => Type::string()],
                            'sound' => ['type' => Type::string()],
                            'display' => ['type' => Type::string()],
                            'max_controllers' => ['type' => Type::int()],
                            'thegamesdb_rating' => ['type' => Type::float()],
                            'released_at' => ['type' => Types::dateTime()],
                            'medias' => ['type' => Type::listOf(Type::id())]
                        ]
                    ])
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                if ($container->get(Session::class)->isAdmin()) {
                    $platform = \App\Models\GamePlatform::query()->find($args['platform']['id']);
                    if ($platform == NULL){
                        return new \Exception('Unknown GamePlatform', 404);
                    }
                    /** @var $platform \App\Models\GamePlatform */
                    $platform->setAttributesFromGraphQL($args['platform'], [
                        'name',
                        'description',
                        'short',
                        'manufacturer',
                        'cpu',
                        'memory',
                        'graphics',
                        'sound',
                        'display',
                        'media',
                        'max_controllers',
                        'thegamesdb_rating',
                        'released_at'
                    ]);

                    if (isset($args['platform']['medias'])) {
                        foreach ($args['platform']['medias'] as $mediaId) {
                            /** @var $media \App\Models\GameMedia */
                            $media = \App\Models\GameMedia::query()->find($mediaId);
                            if ($media != NULL) {
                                $media['platform_id'] = $platform['id'];
                                $media->save();
                            } else {
                                new \Exception("Unknown media '{$media}'", 404);
                            }
                        }
                    }
                    return $platform->save();
                } else {
                    return new \Exception('Forbidden', 403);
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
                    $editor = \App\Models\GameEditor::query()->find($args['id']);
                    if ($editor == NULL){
                        return new \Exception('Unknown GameEditor', 404);
                    }
                    return \App\Models\GameEditor::destroy($editor['id']);
                } else {
                    return new \Exception('Forbidden', 403);
                }
            }
        ];
    }
}
