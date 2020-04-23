<?php

namespace App\GraphQL\Query;

use App\Auth\Session;
use App\GraphQL\Types;
use Faker\Provider\Uuid;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Psr\Container\ContainerInterface;

class GameEditor
{
    public static function getMany()
    {
        return [
            'type' => Type::listOf(Types::gameEditor()),
            'description' => 'Get many GameEditors',
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
                return \App\Models\GameEditor::query()
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
            'type' => Types::gameEditorWithDepth(),
            'description' => 'Get a game editor by id',
            'args' => [
                [
                    'name' => 'id',
                    'description' => 'The Id of the game editor',
                    'type' => Type::string()
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                $editor = \App\Models\GameEditor::query()->find($args['id']);
                if ($editor == NULL) {
                    return new \Exception('Unknown GameEditor', 404);
                } else {
                    return $editor
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
                'name' => 'GameEditorStoreOutput',
                'fields' => [
                    'id' => ['type' => Type::id()],
                    'saved' => ['type' => Type::boolean()]
                ]
            ]),
            'args' => [
                [
                    'name' => 'editor',
                    'description' => 'GameEditor to store',
                    'type' => Type::nonNull(new InputObjectType([
                        'name' => 'GameEditorStoreInput',
                        'fields' => [
                            'name' => ['type' => Type::nonNull(Type::string())],
                            'description' => ['type' => Type::nonNull(Type::string())]
                        ]
                    ]))
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                if ($container->get(Session::class)->isAdmin()) {
                    $editor = new \App\Models\GameEditor();
                    $editor['id'] = Uuid::uuid();
                    $editor->setAttributesFromGraphQL($args['editor'], [
                        'name',
                        'description'
                    ]);

                    return ['id' => $editor['id'], 'saved' => $editor->save()];
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
                'editor' => [
                    'type' => new InputObjectType([
                        'name' => 'GameEditorUpdateInput',
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
                    $editor = \App\Models\GameEditor::query()->find($args['editor']['id']);
                    if ($editor == NULL){
                        return new \Exception('Unknown GameEditor', 404);
                    }
                    $editor['name'] = $args['editor']['name'];
                    $editor['description'] = $args['editor']['description'];
                    return $editor->save();
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
