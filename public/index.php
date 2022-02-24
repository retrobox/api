<?php

use App\App;
use App\Utils\ContainerBuilder;
use App\Utils\DotEnv;
use Slim\Factory\AppFactory;
use function App\addRoutes;

require '../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

App::setBasePath(dirname(__DIR__));

DotEnv::load();

date_default_timezone_set('Europe/Paris');

function dd(...$args)
{
    foreach ($args as $arg) {
        dump($arg);
    }
    die();
}

if (getenv('SENTRY_ENABLE') && is_string(getenv('SENTRY_DSN')))
{
    Sentry\init(['dsn' => getenv('SENTRY_DSN') ]);
}

$container = ContainerBuilder::direct();
$app = AppFactory::create(container: $container);

$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

require '../App/routes.php';

addRoutes($app);

//WhoopsGuard::load($app, $app->getContainer());

try {
    $app->run();
} catch (Throwable $e) {
    if (getenv("SENTRY_ENABLE")) {
        Sentry\captureException($e);
    }
    throw $e;
}
