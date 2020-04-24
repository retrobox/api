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

class GameTag
{
    public static function getMany()
    {
        return [
            'type' => Type::listOf(Types::gameTagWithDepth()),
            'description' => 'Get many GameTags',
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
            'resolve' => function ($_, $args) {
                return \App\Models\GameTag::query()
                    ->withCount('games')
                    ->limit($args['limit'])
                    ->orderBy($args['orderBy'], strtolower($args['orderDir']))
                    ->get();
            }
        ];
    }

    public static function getOne()
    {
        return [
            'type' => Types::gameTagWithDepth(),
            'description' => 'Get a game tag by id',
            'args' => [
                [
                    'name' => 'id',
                    'description' => 'The Id of the game editor',
                    'type' => Type::string()
                ]
            ],
            'resolve' => function ($_, $args) {
                $tag = \App\Models\GameTag::query()->find($args['id']);
                if ($tag == NULL) {
                    return new Exception('Unknown GameTag', 404);
                } else {
                    return $tag
                        ->with('games')
                        ->first();
                }
            }
        ];
    }

    public static function store()
    {
        return [
            'type' => new ObjectType([
                'name' => 'GameTagStoreOutput',
                'fields' => [
                    'id' => ['type' => Type::id()],
                    'saved' => ['type' => Type::boolean()]
                ]
            ]),
            'args' => [
                [
                    'name' => 'tag',
                    'description' => 'GameTag to store',
                    'type' => Type::nonNull(new InputObjectType([
                        'name' => 'GameTagStoreInput',
                        'fields' => [
                            'name' => ['type' => Type::nonNull(Type::string())],
                            'icon' => ['type' => Type::string()],
                            'description' => ['type' => Type::string()]
                        ]
                    ]))
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                if ($container->get(Session::class)->isAdmin()) {
                    $tag = new \App\Models\GameTag();
                    $tag['id'] = Uuid::uuid();
                    $tag->setAttributesFromGraphQL($args['tag'], [
                        'name',
                        'description',
                        'icon'
                    ]);

                    return ['id' => $tag['id'], 'saved' => $tag->save()];
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
                'tag' => [
                    'type' => new InputObjectType([
                        'name' => 'GameTagUpdateInput',
                        'fields' => [
                            'id' => Type::id(),
                            'name' => Type::nonNull(Type::string()),
                            'description' => Type::nonNull(Type::string())
                        ]
                    ])
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                if ($container->get(Session::class)->isAdmin()) {
                    $tag = \App\Models\GameTag::query()->find($args['tag']['id']);
                    if ($tag == NULL){
                        return new Exception('Unknown GameTag', 404);
                    }
                    $tag->setAttributesFromGraphQL($args['tag'], [
                        'name',
                        'description',
                        'icon'
                    ]);
                    return $tag->save();
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
                    $tag = \App\Models\GameTag::query()->find($args['id']);
                    if ($tag == NULL){
                        return new Exception('Unknown GameTag', 404);
                    }
                    return \App\Models\GameTag::destroy($tag['id']);
                } else {
                    return new Exception('Forbidden', 403);
                }
            }
        ];
    }
}
