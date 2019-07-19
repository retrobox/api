<?php

namespace App\Utils;

use Psr\Container\ContainerInterface;

class WhoopsGuard
{
    public static function load(\Slim\App $app, ContainerInterface $container)
    {
        if (boolval(getenv('APP_DEBUG'))) {
            $whoopsGuard = new \Zeuxisoo\Whoops\Provider\Slim\WhoopsGuard();
            $whoopsGuard->setApp($app);
            $whoopsGuard->setRequest($container->get('request'));
            $whoopsGuard->setHandlers([]);
            $whoopsGuard->install();
        }
    }
}

