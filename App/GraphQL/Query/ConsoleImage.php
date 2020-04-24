<?php

namespace App\GraphQL\Query;

use App\Auth\Session;
use App\GraphQL\Types;
use Exception;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Psr\Container\ContainerInterface;

class ConsoleImage
{
    public static function getMany()
    {
        return [
            'type' => Type::listOf(Types::consoleImage()),
            'description' => 'Get many console image',
            'resolve' => fn () => \App\Models\ConsoleImage::all()
        ];
    }

    public static function getOne()
    {
        return [
            'type' => Types::consoleImage(),
            'description' => 'Get a console image',
            'args' => [
                [
                    'name' => 'id',
                    'description' => 'The Id of the console image',
                    'type' => Type::string()
                ]
            ],
            'resolve' => function ($_, $args) {
                $item = \App\Models\ConsoleImage::query()->find($args['id']);
                if ($item === NULL)
                    return new Exception("Unknown console image", 404);
                return $item;
            }
        ];
    }

    public static function store()
    {
        return [
            'type' => new ObjectType([
                'name' => 'ConsoleImageStoreOutput',
                'fields' => [
                    'id' => ['type' => Type::id()],
                    'saved' => ['type' => Type::boolean()]
                ]
            ]),
            'args' => [
                [
                    'name' => 'image',
                    'description' => 'Image to store',
                    'type' => Type::nonNull(new InputObjectType([
                        'name' => 'ConsoleImageStoreInput',
                        'fields' => [
                            'console_version' => ['type' => Type::nonNull(Type::string())],
                            'software_version' => ['type' => Type::nonNull(Type::string())],
                            'description' => ['type' => Type::string()]
                        ]
                    ]))
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                if (!$container->get(Session::class)->isAdmin())
                    return new Exception("Forbidden", 403);

                $image = new \App\Models\ConsoleImage();
                $image['id'] = uniqid();
                $image->setAttributesFromGraphQL($args['image'], ['console_version', 'software_version', 'description']);

                $filter = array_filter($container->get('console-versions'), fn ($v) => $v['id'] === $image['console_version']);
                if (count($filter) !== 1)
                    return new Exception("Unknown console version", 404);

                $image->generateVersion();
                if (\App\Models\ConsoleImage::query()
                    ->where('version', '=', $image['version'])
                    ->count() !== 0)
                    return new Exception("Version already exists", 400);

                return [
                    'saved' => $image->save(),
                    'id' => $image['id']
                ];
            }
        ];
    }

    public static function update()
    {
        return [
            'type' => Type::boolean(),
            'description' => 'Update a console image',
            'args' => [
                [
                    'name' => 'image',
                    'description' => 'Console image to update',
                    'type' => Type::nonNull(new InputObjectType([
                        'name' => 'ConsoleImageUpdateInput',
                        'fields' => [
                            'id' => ['type' => Type::nonNull(Type::id())],
                            'software_version' => ['type' => Type::nonNull(Type::string())],
                            'description' => ['type' => Type::string()]
                        ]
                    ]))
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                if (!$container->get(Session::class)->isAdmin())
                    return new Exception("Forbidden", 403);

                $image = \App\Models\ConsoleImage::query()
                    ->find($args['image']['id']);

                if ($image === NULL)
                    return new Exception("Unknown console image", 404);

                $image->setAttributesFromGraphQL($args['image'], ['software_version', 'description']);
                $image->generateVersion();

                if (\App\Models\ConsoleImage::query()
                        ->where('version', '=', $image['version'])
                        ->where('id', '!=', $image['id'])
                        ->count() === 1)
                    return new Exception("Version already exists", 400);

                return $image->save();
            }
        ];
    }

    public static function destroy()
    {
        return [
            'type' => Type::boolean(),
            'args' => [
                'id' => [ 'type' => Type::nonNull(Type::id()) ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                if (!$container->get(Session::class)->isAdmin())
                    return new Exception("Forbidden", 403);

                $order = \App\Models\ConsoleImage::query()->find($args['id']);

                if ($order == NULL)
                    return new Exception("Unknown console image", 404);

                return \App\Models\ConsoleImage::destroy($order['id']);
            }
        ];
    }
}
