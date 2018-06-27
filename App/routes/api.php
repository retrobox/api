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
    $this->map(['POST','OPTIONS'], 'graphql', [\App\Controllers\GraphQlController::class, 'newRequest']);
    $this->get('paysafecard/get_url', [\App\Controllers\Payment\PaysafeCardController::class, 'getUrl']);
    $this->post('paysafecard/capture_payment', [\App\Controllers\Payment\PaysafeCardController::class, 'postCapturePayment']);
    $this->get('paysafecard/success', [\App\Controllers\Payment\PaysafeCardController::class, 'getSuccess']);
    $this->get('paysafecard/failure', [\App\Controllers\Payment\PaysafeCardController::class, 'getFailure']);
})->add(new \App\Middlewares\CorsMiddleware());
