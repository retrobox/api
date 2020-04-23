<?php

namespace App\GraphQL\Query;

use App\Auth\Session;
use App\GraphQL\Types;
use Faker\Provider\Uuid;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Psr\Container\ContainerInterface;

class Game
{
    public static function getMany()
    {
        return [
            'type' => Type::listOf(Types::game()),
            'description' => 'Get many games',
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
                return \App\Models\Game::query()
                    ->with('editor')
                    ->limit($args['limit'])
                    ->orderBy($args['orderBy'], strtolower($args['orderDir']))
                    ->get();
            }
        ];
    }

    public static function getOne()
    {
        return [
            'type' => Types::game(),
            'description' => 'Get a game by id',
            'args' => [
                [
                    'name' => 'id',
                    'description' => 'The Id of the game',
                    'type' => Type::string()
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                $game = \App\Models\Game::query()->find($args['id']);
                if ($game == NULL) {
                    return new \Exception('Unknown Game', 404);
                } else {
                    return $game
                        ->with('editor')
                        ->first();
                }
            }
        ];
    }

    public static function store()
    {
        return [
            'type' => new ObjectType([
                'name' => 'GameStoreOutput',
                'fields' => [
                    'id' => ['type' => Type::id()],
                    'saved' => ['type' => Type::boolean()]
                ]
            ]),
            'args' => [
                [
                    'name' => 'game',
                    'description' => 'Game to store',
                    'type' => Type::nonNull(new InputObjectType([
                        'name' => 'GameStoreInput',
                        'fields' => [
                            'name' => ['type' => Type::nonNull(Type::string())],
                            'description' => ['type' => Type::nonNull(Type::string())],
                            'esrb_level' => ['type' => Type::string()],
                            'locales' => ['type' => Type::string()],
                            'players' => ['type' => Type::string()],
                            'thegamesdb_rating' => ['type' => Type::float()],
                            'rom_url' => ['type' => Type::string()],
                            'editor_id' => ['type' => Type::string()],
                            'platform_id' => ['type' => Type::string()],
                            'released_at' => ['type' => Types::dateTime()],
                            'tags' => ['type' => Type::listOf(Type::id())],
                            'medias' => ['type' => Type::listOf(Type::id())]
                        ]
                    ]))
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                if ($container->get(Session::class)->isAdmin()) {
                    $game = new \App\Models\Game();
                    $game['id'] = Uuid::uuid();
                    $game->setAttributesFromGraphQL($args['game'], [
                        'name',
                        'description',
                        'esrb_level',
                        'locales',
                        'players',
                        'thegamesdb_rating',
                        'rom_url',
                        'editor_id',
                        'platform_id',
                        'released_at'
                    ]);

                    if (isset($args['game']['tags'])) {
                        $tags = [];
                        foreach ($args['game']['tags'] as $tagId) {
                            $tag = \App\Models\GameTag::query()->find($tagId);
                            if ($tag != NULL) {
                                $tags[] = $tagId;
                            } else {
                                return new \Exception("Unknown tag '{$tagId}'", 404);
                            }
                        }
                        $game->tags()->toggle($tags);
                    }

                    if (isset($args['game']['medias'])) {
                        foreach ($args['game']['medias'] as $mediaId) {
                            $media = \App\Models\GameMedia::query()->find($mediaId);
                            if ($media != NULL) {
                                $media->game()->associate($args['game']['id']);
                                $media->save();
                            } else {
                                new \Exception("Unknown media '{$media}'", 404);
                            }
                        }
                    }

                    return ['id' => $game['id'], 'saved' => $game->save()];
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
                'game' => [
                    'type' => new InputObjectType([
                        'name' => 'GameUpdateInput',
                        'fields' => [
                            'id' => ['type' => Type::nonNull(Type::id())],
                            'name' => ['type' => Type::nonNull(Type::string())],
                            'description' => ['type' => Type::nonNull(Type::string())],
                            'esrb_level' => ['type' => Type::string()],
                            'locales' => ['type' => Type::string()],
                            'players' => ['type' => Type::string()],
                            'thegamesdb_rating' => ['type' => Type::float()],
                            'rom_url' => ['type' => Type::string()],
                            'editor_id' => ['type' => Type::string()],
                            'platform_id' => ['type' => Type::string()],
                            'released_at' => ['type' => Types::dateTime()],
                            'tags' => ['type' => Type::listOf(Type::id())],
                            'medias' => ['type' => Type::listOf(Type::id())]
                        ]
                    ])
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                if ($container->get(Session::class)->isAdmin()) {
                    /** @var \App\Models\Game $game */
                    $game = \App\Models\Game::query()->find($args['game']['id']);
                    if ($game == NULL){
                        return new \Exception('Unknown Game', 404);
                    }
                    $game->setAttributesFromGraphQL($args['game'], [
                        'name',
                        'description',
                        'esrb_level',
                        'locales',
                        'players',
                        'thegamesdb_rating',
                        'rom_url',
                        'editor_id',
                        'platform_id',
                        'released_at'
                    ]);

                    if (isset($args['game']['tags'])) {
                        $tags = [];
                        foreach ($args['game']['tags'] as $tagId) {
                            $tag = \App\Models\GameTag::query()->find($tagId);
                            if ($tag != NULL) {
                                $tags[] = $tagId;
                            } else {
                                return new \Exception("Unknown tag '{$tagId}'", 404);
                            }
                        }
                        $game->tags()->toggle($tags);
                    }

                    if (isset($args['game']['medias'])) {
                        foreach ($args['game']['medias'] as $mediaId) {
                            $media = \App\Models\GameMedia::query()->find($mediaId);
                            if ($media != NULL) {
                                $media->game()->associate($args['game']['id']);
                                $media->save();
                            } else {
                                new \Exception("Unknown media '{$media}'", 404);
                            }
                        }
                    }

                    return $game->save();
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
                    $game = \App\Models\Game::query()->find($args['id']);
                    if ($game == NULL){
                        return new \Exception('Unknown game', 404);
                    }
                    $mediaIds = array_map(
                        function ($media) { return $media['id']; },
                        $game->medias()->get()->toArray()
                    );
                    \App\Models\GameMedia::destroy($mediaIds);
                    return \App\Models\Game::destroy($game['id']);
                } else {
                    return new \Exception('Forbidden', 403);
                }
            }
        ];
    }
}
