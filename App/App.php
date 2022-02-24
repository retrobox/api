<?php

namespace App;

use App\Utils\ContainerBuilder;
use RKA\Middleware\IpAddress;

class App
{
    /**
     * The absolute fs path of the root of the application
     *
     * @var string
     */
    private static string $basePath = '';

    public function __construct()
    {
    }

    protected function configureContainer(\DI\ContainerBuilder $builder)
    {
        ContainerBuilder::getContainerBuilder($builder);
    }

    public static function setBasePath(string $basePath): void
    {
        self::$basePath = $basePath;
    }

    public static function getBasePath(): string
    {
        return self::$basePath;
    }
}
