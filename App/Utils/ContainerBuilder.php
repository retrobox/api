<?php

namespace App\Utils;

use App\App;
use Psr\Container\ContainerInterface;

class ContainerBuilder
{
    private static $definitions = [
        'app',
        'api',
        'database',
        'shop',
        'containers'
    ];

    public static function getContainerBuilder(\DI\ContainerBuilder $containerBuilder = null): \DI\ContainerBuilder
    {
        if ($containerBuilder == null){
            $containerBuilder = new \DI\ContainerBuilder();
        }
        foreach (self::$definitions as $def) {
            $containerBuilder->addDefinitions(App::getBasePath() . "/App/config/{$def}.php");
        }

        return $containerBuilder;
    }

    public static function getContainerFromBuilder(\DI\ContainerBuilder $containerBuilder): ContainerInterface
    {
        try {
            return $containerBuilder->build();
        } catch (\Exception $e) {
            return NULL;
        }
    }

    public static function direct(): ContainerInterface
    {
        return self::getContainerFromBuilder(self::getContainerBuilder());
    }
}