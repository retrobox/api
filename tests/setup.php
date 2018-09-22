<?php

class Setup
{
    static function get(): \Psr\Container\ContainerInterface
    {
        $dotEnv = new Dotenv\Dotenv(dirname(__DIR__));
        $dotEnv->load();
        $containerBuilder = new \DI\ContainerBuilder();
        $containerBuilder->addDefinitions(dirname(__DIR__) . '/App/config/containers.php');
        $containerBuilder->addDefinitions(dirname(__DIR__) . '/App/config/app.php');
        $containerBuilder->addDefinitions(dirname(__DIR__) . '/App/config/api.php');
        $containerBuilder->addDefinitions(dirname(__DIR__) . '/App/config/shop.php');
        $containerBuilder->addDefinitions(dirname(__DIR__) . '/App/config/database.php');
        return $containerBuilder->build();
    }
}