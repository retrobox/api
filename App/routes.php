<?php
/*
|--------------------------------------------------------------------------
| Api routing
|--------------------------------------------------------------------------
|
| Register it all your api routes
|
*/
$app->add(new \App\Middlewares\CorsMiddleware());
$app->group('/', function (){
    $this->get('', [\App\Controllers\PagesController::class, 'getHome']);
    $this->map(['POST', 'OPTIONS'], 'newsletter/subscribe', [\App\Controllers\NewsletterController::class, 'postSubscribe']);
    $this->get('newsletter/event', [\App\Controllers\NewsletterController::class, 'getEvent']);
    $this->post('newsletter/event', [\App\Controllers\NewsletterController::class, 'postEvent']);

    $this->map(['POST','OPTIONS'], 'graphql', [\App\Controllers\GraphQlController::class, 'newRequest'])
        ->add(new \App\Middlewares\JWTMiddleware($this->getContainer()));

    $this->get('paysafecard/get_url', [\App\Controllers\Payment\PaysafeCardController::class, 'getUrl']);
    $this->post('paysafecard/capture_payment', [\App\Controllers\Payment\PaysafeCardController::class, 'postCapturePayment']);
    $this->get('paysafecard/success', [\App\Controllers\Payment\PaysafeCardController::class, 'getSuccess']);
    $this->get('paysafecard/failure', [\App\Controllers\Payment\PaysafeCardController::class, 'getFailure']);
    $this->map(['POST','OPTIONS'], 'stripe/execute', [\App\Controllers\Payment\StripeController::class, 'postExecute'])
        ->add(new \App\Middlewares\JWTMiddleware($this->getContainer()));
    $this->map(['POST','OPTIONS'], 'paypal/get-url', [\App\Controllers\Payment\PaypalController::class, 'postGetUrl'])
        ->add(new \App\Middlewares\JWTMiddleware($this->getContainer()));
    $this->get('paypal/execute', [\App\Controllers\Payment\PaypalController::class, 'postExecute']);

    $this->group('account/', function (){
        $this->get('login', [\App\Controllers\AccountController::class, 'getLogin']);
        $this->get('register', [\App\Controllers\AccountController::class, 'getLogin']);
        $this->get('login-desktop', [\App\Controllers\AccountController::class, 'getLoginDesktop']);
        $this->post('login-desktop', [\App\Controllers\AccountController::class, 'postLoginDesktop'])
            ->add(new \App\Middlewares\JWTMiddleware($this->getContainer()));

        $this->map(['GET', 'OPTIONS'], 'info', [\App\Controllers\AccountController::class, 'getInfo'])
            ->add(new \App\Middlewares\JWTMiddleware($this->getContainer()));

        $this->map(['GET', 'POST', 'OPTIONS'], 'execute', [\App\Controllers\AccountController::class, 'execute'])
            ->add(new \RKA\Middleware\IpAddress());
    });

    $this->group('dashboard', function () {
        $this->map(['GET', 'OPTIONS'], '[/]', [\App\Controllers\DashboardController::class, 'getDashboard']);
        $this->map(['GET', 'OPTIONS'], '/delete', [\App\Controllers\DashboardController::class, 'getDelete']);
    })->add(new \App\Middlewares\JWTMiddleware($this->getContainer()));

    //shop
    $this->group('shop/', function (){
        $this->get('prices', [\App\Controllers\ShopController::class, 'getPrices']);
        $this->get('{locale}/categories', [\App\Controllers\ShopController::class, 'getCategories']);
        $this->get('{locale}/item/{slug}', [\App\Controllers\ShopController::class, 'getItem']);
    });

    // downloads
    $this->get('downloads', [\App\Controllers\DownloadController::class, 'getDownloads']);

    $this->group('docs/', function (){
        $this->get('{locale}/{slug}', [\App\Controllers\DocsController::class, 'getPage']);
    });

    $this->get('health', [\App\Controllers\HealthController::class, 'getHealth']);
});
