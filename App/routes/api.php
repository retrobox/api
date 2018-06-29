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
    $this->map(['POST','OPTIONS'], 'stripe/execute', [\App\Controllers\Payment\StripeController::class, 'postExecute'])->add(new \App\Middlewares\JWTMiddleware($this->getContainer()));
    $this->get('account/login', [\App\Controllers\Account\StailEuController::class, 'getLogin']);
    $this->get('account/register', [\App\Controllers\Account\StailEuController::class, 'getRegister']);
    $this->get('account/execute', [\App\Controllers\Account\StailEuController::class, 'getExecute']);
})->add(new \App\Middlewares\CorsMiddleware());
