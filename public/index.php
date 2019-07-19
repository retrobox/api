<?php
require '../vendor/autoload.php';

date_default_timezone_set('Europe/Paris');

$app = new \App\App();

\App\Utils\DotEnv::load();

\App\Utils\WhoopsGuard::load($app, $app->getContainer());

$app->run();
