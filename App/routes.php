<?php

namespace App;

use Slim\Routing\RouteCollectorProxy;

function addRoutes(\Slim\App $app): void
{
    $container = $app->getContainer();
    $app->add(new Middlewares\CorsMiddleware($container));

    $app->get('/', [Controllers\PagesController::class, 'getHome']);
    $app->get('/ping', [Controllers\PagesController::class, 'getPing']);

    $app->map(['POST', 'OPTIONS'], '/newsletter/subscribe', [Controllers\NewsletterController::class, 'postSubscribe']);
    $app->get('/newsletter/event', [Controllers\NewsletterController::class, 'getEvent']);
    $app->post('/newsletter/event', [Controllers\NewsletterController::class, 'postEvent']);

    $app->map(['POST', 'OPTIONS'], '/graphql', [Controllers\GraphQlController::class, 'newRequest'])
        ->add(new Middlewares\JWTMiddleware($container));

// STRIPE
    $app->map(['POST', 'OPTIONS'], '/stripe/create', [Controllers\Payment\StripeController::class, 'postCreateSession'])
        ->add(new Middlewares\JWTMiddleware($container));
    $app->map(['POST', 'OPTIONS'], '/stripe/execute', [Controllers\Payment\StripeController::class, 'postExecute']);

// PAYPAL
    $app->map(['POST', 'OPTIONS'], '/paypal/get-url', [Controllers\Payment\PaypalController::class, 'postGetUrl'])
        ->add(new Middlewares\JWTMiddleware($container));
//$app->get('/paypal/execute', [Controllers\Payment\PaypalController::class, 'postExecute']);
    $app->map(['POST', 'OPTIONS'], '/paypal/execute', [Controllers\Payment\PaypalController::class, 'postExecute']);

    $app->group('/account', function (RouteCollectorProxy $group) use ($container) {
        $group->get('/login', [Controllers\AccountController::class, 'getLogin']);
        $group->get('/register', [Controllers\AccountController::class, 'getLogin']);
        $group->get('/login-desktop', [Controllers\AccountController::class, 'getLoginDesktop']);
        $group->post('/login-desktop', [Controllers\AccountController::class, 'postLoginDesktop'])
            ->add(new Middlewares\JWTMiddleware($container));

        $group->map(['GET', 'OPTIONS'], '/info', [Controllers\AccountController::class, 'getInfo'])
            ->add(new Middlewares\JWTMiddleware($container));

        $group->map(['POST', 'OPTIONS'], '/execute', [Controllers\AccountController::class, 'execute']);
    });

    $app->group('/dashboard', function (RouteCollectorProxy $group) {
        $group->map(['GET', 'OPTIONS'], '[/]', [Controllers\DashboardController::class, 'getDashboard']);
        $group->map(['POST', 'OPTIONS'], '/upload', [Controllers\UploadController::class, 'postUpload']);
        $group->map(['GET', 'OPTIONS'], '/delete', [Controllers\DashboardController::class, 'getDelete']);
    })->add(new Middlewares\JWTMiddleware($container));

    $app->group('/shop', function (RouteCollectorProxy $group) {
        $group->get('/address', [Controllers\ShopController::class, 'getQueryAddress'])
            ->add(new Middlewares\JWTMiddleware($group->getContainer()));
        $group->get('/storage-prices', [Controllers\ShopController::class, 'getStoragePrices']);
        $group->get('/shipping-prices', [Controllers\ShopController::class, 'getShippingPrices']);
        $group->get('/{locale}/categories', [Controllers\ShopController::class, 'getCategories']);
        $group->get('/{locale}/item/{slug}', [Controllers\ShopController::class, 'getItem']);
    });

    $app->post('/console/verify', [Controllers\ConsoleController::class, 'verifyConsole']);

    $app->get('/downloads', [Controllers\DownloadController::class, 'getDownloads']);

// $app->group('/docs', function (RouteCollectorProxy $group) {
//     $group->get('/{locale}/{slug}', [Controllers\DocsController::class, 'getPage']);
// });

    $app->get('/cache/shop/generate', [Controllers\PagesController::class, 'generateShopCache'])
        ->add(new Middlewares\JWTMiddleware($container));
    $app->get('/websocket/connexions', [Controllers\PagesController::class, 'getWebSocketConnexions'])
        ->add(new Middlewares\JWTMiddleware($container));
    $app->get('/test-send-email-event', [Controllers\PagesController::class, 'testSendEmailEvent'])
        ->add(new Middlewares\JWTMiddleware($container));

    $app->get('/countries/{locale}', [Controllers\CountriesController::class, 'getCountries']);

    $app->get('/health', [Controllers\HealthController::class, 'getHealth']);
    $app->get('/dangerously-truncate-table', [Controllers\IntegrationTestController::class, 'getDangerouslyTruncateTables']);
    $app->get('/jwt', [Controllers\IntegrationTestController::class, 'getUserToken'])
        ->add(new Middlewares\JWTMiddleware($container));

}
