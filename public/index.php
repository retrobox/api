<?php

use App\App;
use App\Utils\DotEnv;
use App\Utils\WhoopsGuard;

require '../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

App::setBasePath(dirname(__DIR__));

DotEnv::load();

date_default_timezone_set('Europe/Paris');

if (getenv('SENTRY_DSN') !== null && is_string(getenv('SENTRY_DSN')))
    Sentry\init(['dsn' => getenv('SENTRY_DSN') ]);

$app = new App();
WhoopsGuard::load($app, $app->getContainer());
try {
    $app->run();
} catch (Throwable $e) {
    if (boolval(getenv("SENTRY_ENABLE")))
        Sentry\captureException($e);
}