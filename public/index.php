<?php
require '../vendor/autoload.php';

\App\App::setBasePath(dirname(__DIR__));

\App\Utils\DotEnv::load();

date_default_timezone_set('Europe/Paris');

$app = new \App\App();

\App\Utils\WhoopsGuard::load($app, $app->getContainer());

$app->run();
