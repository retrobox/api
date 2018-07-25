<?php
/*
|--------------------------------------------------------------------------
| Api routing
|--------------------------------------------------------------------------
|
| Register it all your api routes
|
*/
$app->group('/', function (){
    $this->get('', [\App\Controllers\PagesController::class, 'getHome']);

    $this->map(['POST','OPTIONS'], 'graphql', [\App\Controllers\GraphQlController::class, 'newRequest'])
        ->add(new \App\Middlewares\JWTMiddleware($this->getContainer()));

    $this->get('paysafecard/get_url', [\App\Controllers\Payment\PaysafeCardController::class, 'getUrl']);
    $this->post('paysafecard/capture_payment', [\App\Controllers\Payment\PaysafeCardController::class, 'postCapturePayment']);
    $this->get('paysafecard/success', [\App\Controllers\Payment\PaysafeCardController::class, 'getSuccess']);
    $this->get('paysafecard/failure', [\App\Controllers\Payment\PaysafeCardController::class, 'getFailure']);
    $this->map(['POST','OPTIONS'], 'stripe/execute', [\App\Controllers\Payment\StripeController::class, 'postExecute'])
        ->add(new \App\Middlewares\JWTMiddleware($this->getContainer()));

    $this->get('account/login', [\App\Controllers\Account\StailEuController::class, 'getLogin']);
    $this->map(['GET', 'OPTIONS'], 'account/info', [\App\Controllers\Account\StailEuController::class, 'getInfo'])
        ->add(new \App\Middlewares\CorsMiddleware())
        ->add(new \App\Middlewares\JWTMiddleware($this->getContainer()));
    $this->get('account/register', [\App\Controllers\Account\StailEuController::class, 'getRegister']);
    $this->map(['GET', 'POST', 'OPTIONS'], 'account/execute', [\App\Controllers\Account\StailEuController::class, 'execute'])
        ->add(new \App\Middlewares\CorsMiddleware());
    //shop
    $this->group('shop/', function (){
        $this->get('{locale}/categories', [\App\Controllers\ShopController::class, 'getCategories']);
        $this->get('{locale}/item/{slug}', [\App\Controllers\ShopController::class, 'getItem']);
    })->add(new \App\Middlewares\CorsMiddleware());
})->add(new \App\Middlewares\CorsMiddleware());
