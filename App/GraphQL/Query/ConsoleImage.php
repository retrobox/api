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
            'args' => [[
                'name' => 'all',
                'description' => 'If true, include unpublished images',
                'type' => Type::boolean(),
                'defaultValue' => false
            ]],
            'resolve' => function (ContainerInterface $container, $args) {
                return \App\Models\ConsoleImage::all()
                    ->filter(fn($image) => $args['all'] || $image['is_available'])
                    ->map(function ($image) use ($container) {
                        $image['url'] = $container->get('services')['os_endpoint'] . $image['path'];
                        return $image;
                    });
            }
        ];
    }

    public static function getOne()
    {
        return [
            'type' => Types::consoleImage(),
            'description' => 'Get a console image',
            'args' => [[
                'name' => 'id',
                'description' => 'The Id of the console image',
                'type' => Type::string()
            ]],
            'resolve' => function (ContainerInterface $container, $args) {
                $image = \App\Models\ConsoleImage::query()->find($args['id']);
                $image['url'] = $container->get('services')['os_endpoint'] . $image['path'];
                if ($image === NULL)
                    return new Exception("Unknown console image", 404);
                return $image;
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
            'args' => [[
                'name' => 'image',
                'description' => 'Image to store',
                'type' => Type::nonNull(new InputObjectType([
                    'name' => 'ConsoleImageStoreInput',
                    'fields' => [
                        'console_version' => ['type' => Type::nonNull(Type::string())],
                        'software_version' => ['type' => Type::nonNull(Type::string())],
                        'size' => ['type' => Type::nonNull(Type::int())],
                        'hash' => ['type' => Type::nonNull(Type::string())],
                        'is_available' => ['type' => Type::boolean(), 'default_value' => false],
                        'description' => ['type' => Type::string()]
                    ]
                ]))
            ]],
            'resolve' => function (ContainerInterface $container, $args) {
                if (!$container->get(Session::class)->isAdmin())
                    return new Exception("Forbidden", 403);

                $image = new \App\Models\ConsoleImage();
                $image['id'] = uniqid();
                $image->setAttributesFromGraphQL(
                    $args['image'],
                    ['console_version', 'software_version', 'description', 'is_available', 'size', 'hash']
                );

                $filter = array_filter($container->get('console-versions'), fn($v) => $v['id'] === $image['console_version']);
                if (count($filter) !== 1)
                    return new Exception("Unknown console version", 404);

                $image->generateExtraFields();
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
            'args' => [[
                'name' => 'image',
                'description' => 'Console image to update',
                'type' => Type::nonNull(new InputObjectType([
                    'name' => 'ConsoleImageUpdateInput',
                    'fields' => [
                        'id' => ['type' => Type::nonNull(Type::id())],
                        'software_version' => ['type' => Type::string()],
                        'description' => ['type' => Type::string()],
                        'is_available' => ['type' => Type::boolean()],
                        'size' => ['type' => Type::int()],
                        'hash' => ['type' => Type::string()]
                    ]
                ]))
            ]],
            'resolve' => function (ContainerInterface $container, $args) {
                if (!$container->get(Session::class)->isAdmin())
                    return new Exception("Forbidden", 403);

                /* @var $image \App\Models\ConsoleImage */
                $image = \App\Models\ConsoleImage::query()
                    ->find($args['image']['id']);

                if ($image === NULL)
                    return new Exception("Unknown console image", 404);

                $image = $image->setAttributesFromGraphQL(
                    $args['image'],
                    ['software_version', 'description', 'is_available', 'size', 'hash']
                );
                $image->generateExtraFields();

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
                'id' => ['type' => Type::nonNull(Type::id())]
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
