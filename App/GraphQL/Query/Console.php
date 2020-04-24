<?php

namespace App\GraphQL\Query;

use App\Auth\Session;
use App\GraphQL\Types;
use App\Utils\WebSocketServerClient;
use Exception;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Psr\Container\ContainerInterface;

class Console
{
    public static function getMany()
    {
        return [
            'type' => Type::listOf(Types::console()),
            'description' => 'Get many consoles',
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
                ],
                [
                    'name' => 'all',
                    'description' => 'Fetch all consoles',
                    'type' => Type::boolean(),
                    'defaultValue' => false
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                $session = $container->get(Session::class);
                $query = \App\Models\Console::query()
                    ->with(['user', 'order'])
                    ->limit($args['limit'])
                    ->orderBy($args['orderBy'], strtolower($args['orderDir']));
                if ($args['all']) {
                    if ($session->isAdmin()) {
                        return $query->get();
                    } else {
                        return new Exception('Forbidden', 403);
                    }
                } else {
                    return $query
                        ->where('user_id', '=', $session->getUserId())
                        ->get();
                }
            }
        ];
    }

    public static function getOne()
    {
        return [
            'type' => Types::console(),
            'description' => 'Get a console',
            'args' => [
                [
                    'name' => 'id',
                    'description' => 'The Id of the console',
                    'type' => Type::string()
                ],
                [
                    'name' => 'with_status',
                    'description' => 'Flag to retrieve console status thought web socket server and overlay',
                    'type' => Type::boolean(),
                    'default' => null
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                $session = $container->get(Session::class);
                $item = \App\Models\Console::with(['user', 'order'])
                    ->find($args['id']);
                if ($item === NULL) {
                    return new Exception('Unknown console', 404);
                }
                if ($session->isAdmin() || $session->getUserId() == $item['user']['id']) {
                    if (isset($args['with_status']) && $args['with_status'] !== null) {
                        $webSocketClient = $container->get(WebSocketServerClient::class);
                        $res = $webSocketClient->getConsoleStatus($item['id']);
                        $item['is_online'] = $res['online'];
                        if ($res['status'] !== null) {
                            $item['up_time'] = $res['status']['up_time'];
                            $item['used_disk_space'] = floatval(str_replace('G', '', $res['status']['disk']['used']));
                            $item['free_disk_space'] = floatval(str_replace('G', '', $res['status']['disk']['free']));
                            $item['disk_usage'] = floatval(str_replace('%', '', $res['status']['disk']['usage']));
                            $item['disk_size'] = floatval(str_replace('G', '', $res['status']['disk']['size'])); // in gigabytes
                            $item['cpu_temp'] = $res['status']['cpu_temp'];
                            $item['gpu_temp'] = $res['status']['gpu_temp'];
                            $item['ip'] = $res['status']['ip'];
                            $item['wifi'] = $res['status']['wifi'];
                            $item['free_memory'] = $res['status']['free_mem'];
                            $item['total_memory'] = $res['status']['total_mem'];
                        }
                    }

                    return $item;
                } else {
                    return new Exception('Forbidden', 403);
                }
            }
        ];
    }

    public static function store()
    {
        return [
            'type' => new ObjectType([
                'name' => 'ConsoleStoreOutput',
                'fields' => [
                    'id' => ['type' => Type::id()],
                    'saved' => ['type' => Type::boolean()]
                ]
            ]),
            'args' => [
                [
                    'name' => 'console',
                    'description' => 'Console to store',
                    'type' => Type::nonNull(new InputObjectType([
                        'name' => 'ConsoleStoreInput',
                        'fields' => [
                            'id' => ['type' => Type::string()],
                            'version' => ['type' => Type::string()],
                            'order_id' => ['type' => Type::string()],
                            'user_id' => ['type' => Type::string()],
                            'color' => ['type' => Type::nonNull(Type::string())],
                            'storage' => ['type' => Type::nonNull(Type::string())]
                        ]
                    ]))
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                //admin only
                if ($container->get(Session::class)->isAdmin()) {
                    $console = new \App\Models\Console();
                    if (
                        !isset($args['console']['id']) ||
                        $args['console']['id'] == NULL ||
                        empty($args['console']['id'])
                    ) {
                        $console['id'] = self::generateRandom(5);
                    } else {
                        $console['id'] = $args['console']['id'];
                    }
                    $console['token'] = self::generateRandom(32);
                    if (isset($args['console']['user_id'])) {
                        $user = \App\Models\User::query()->find($args['console']['user_id']);
                        if ($user != NULL) {
                            $console->user()->associate($user);
                        } else {
                            return new Exception('Unknown user', 404);
                        }
                    }
                    if (isset($args['console']['order_id']) && !empty($args['console']['order_id'])) {
                        $order = \App\Models\ShopOrder::query()->find($args['console']['order_id']);
                        if ($order != NULL) {
                            $console->order()->associate($order);
                        } else {
                            return new Exception('Unknown order', 404);
                        }
                    }
                    if (isset($args['console']['version']) && !empty($args['console']['version'])) {
                        $console['version'] = $args['console']['version'];
                    } else {
                        // by default we give the console the last version
                        $console['version'] = last($container->get('console-versions'))['id'];
                    }
                    $console['color'] = $args['console']['color'];
                    $console['storage'] = $args['console']['storage'];
                    if ($console->save()) {
                        return [
                            'saved' => true,
                            'id' => $console['id']
                        ];
                    } else {
                        return [
                            'saved' => false,
                            'id' => ''
                        ];
                    }
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
            'description' => 'Update a console',
            'args' => [
                [
                    'name' => 'console',
                    'description' => 'Console to update',
                    'type' => Type::nonNull(new InputObjectType([
                        'name' => 'ConsoleUpdateInput',
                        'fields' => [
                            'id' => ['type' => Type::string()],
                            'version' => ['type' => Type::string()],
                            'order_id' => ['type' => Type::string()],
                            'user_id' => ['type' => Type::string()],
                            'color' => ['type' => Type::nonNull(Type::string())],
                            'storage' => ['type' => Type::nonNull(Type::string())]
                        ]
                    ]))
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                $session = $container->get(Session::class);
                $console = \App\Models\Console::with(['user', 'order'])
                    ->find($args['console']['id']);
                if ($console === NULL) {
                    return new Exception('Unknown console', 404);
                }
                if ($session->isAdmin()) {
                    /** @var $console \App\Models\Console */
                    $console->setAttributesFromGraphQL($args['console'], [
                        'id',
                        'order_id',
                        'user_id',
                        'color',
                        'storage',
                        'version'
                    ]);

                    return $console->save();
                } else {
                    return new Exception('Forbidden', 403);
                }
            }
        ];
    }

    public static function shutdown()
    {
        return [
            'type' => Type::boolean(),
            'description' => 'Shutdown a console',
            'args' => [
                [
                    'name' => 'id',
                    'description' => 'The Id of the console',
                    'type' => Type::string()
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                $session = $container->get(Session::class);
                $item = \App\Models\Console::query()
                    ->find($args['id']);
                if ($item === NULL) {
                    return new Exception('Unknown console', 404);
                }
                if ($session->isAdmin() || $session->getUserId() == $item['user_id']) {
                    $webSocketClient = $container->get(WebSocketServerClient::class);
                    return $webSocketClient->shutdownConsole($item['id']);
                } else {
                    return new Exception('Forbidden', 403);
                }
            }
        ];
    }

    public static function reboot()
    {
        return [
            'type' => Type::boolean(),
            'description' => 'Reboot a console',
            'args' => [
                [
                    'name' => 'id',
                    'description' => 'The Id of the console',
                    'type' => Type::string()
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                $session = $container->get(Session::class);
                $item = \App\Models\Console::query()
                    ->find($args['id']);
                if ($item === NULL) {
                    return new Exception('Unknown console', 404);
                }
                if ($session->isAdmin() || $session->getUserId() == $item['user_id']) {
                    $webSocketClient = $container->get(WebSocketServerClient::class);
                    return $webSocketClient->rebootConsole($item['id']);
                } else {
                    return new Exception('Forbidden', 403);
                }
            }
        ];
    }

    public static function resetToken()
    {
        return [
            'type' => new ObjectType([
                'name' => 'ConsoleResetTokenOutput',
                'fields' => [
                    'token' => ['type' => Type::string()],
                    'overlay_killed' => ['type' => Type::boolean()]
                ]
            ]),
            'description' => 'Reset a console token',
            'args' => [
                [
                    'name' => 'id',
                    'description' => 'The Id of the console',
                    'type' => Type::string()
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                $session = $container->get(Session::class);
                $item = \App\Models\Console::query()
                    ->find($args['id']);
                if ($item === NULL) {
                    return new Exception('Unknown console', 404);
                }
                if ($session->isAdmin() || $session->getUserId() == $item['user_id']) {
                    $item['token'] = self::generateRandom(32);
                    $item->save();
                    $webSocketClient = $container->get(WebSocketServerClient::class);
                    return [
                        'token' => $item['token'],
                        'overlay_killed' => $webSocketClient->killOverlay($item['id'])
                    ];
                } else {
                    return new Exception('Forbidden', 403);
                }
            }
        ];
    }

    public static function openConsoleTerminalSession()
    {
        return [
            'type' => Type::boolean(),
            'description' => 'Open a remote terminal session on a console',
            'args' => [
                [
                    'name' => 'id',
                    'description' => 'The Id of the console',
                    'type' => Type::string()
                ],
                [
                    'name' => 'webSessionId',
                    'description' => 'The id of the websocket session opened by a web client',
                    'type' => Type::string(),
                    'default' => ''
                ]
            ],
            'resolve' => function (ContainerInterface $container, $args) {
                $session = $container->get(Session::class);
                $item = \App\Models\Console::query()
                    ->find($args['id']);
                if ($item === NULL) {
                    return new Exception('Unknown console', 404);
                }
                if ($session->isAdmin() || $session->getUserId() == $item['user_id']) {
                    $webSocketClient = $container->get(WebSocketServerClient::class);
                    return $webSocketClient->openConsoleTerminalSession($item['id'], $args['webSessionId'], $item['user_id']);
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
                    $order = \App\Models\Console::query()->find($args['id']);
                    if ($order == NULL){
                        return new Exception('Unknown Console', 404);
                    }
                    return \App\Models\Console::destroy($order['id']);
                } else {
                    return new Exception('Forbidden', 403);
                }
            }
        ];
    }

    public static function getConsoleVersions()
    {
        return [
            'type' => Type::listOf(Types::consoleVersion()),
            'description' => 'Get all the console versions',
            'resolve' => function (ContainerInterface $container) {
                return self::getConsoleWithImageUrlRaw($container);
            }
        ];
    }

    private static function getConsoleWithImageUrlRaw(ContainerInterface $container) {
        return array_map(function ($version) use ($container) {
            $version['image_url'] = $container->get('services')['card_images_endpoint'] . '/' . $version['id'] . '.img';
            return $version;
        }, $container->get('console-versions'));
    }

    public static function generateRandom(int $length): string
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randString = '';
        for ($i = 0; $i < $length; $i++) {
            $randString = $randString . $characters[rand(0, strlen($characters) - 1)];
        }
        return $randString;
    }
}
