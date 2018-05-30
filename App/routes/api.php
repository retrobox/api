<?php
/*
|--------------------------------------------------------------------------
| Api routing
|--------------------------------------------------------------------------
|
| Register it all your api routes
|
*/
$app->post('/', [\App\Controllers\GraphQlController::class, 'newRequest']);
$app->get('/', [\App\Controllers\PagesController::class, 'getHome']);
$app->get('/paysafecard/get_url', [\App\Controllers\Payment\PaysafeCardController::class, 'getUrl']);
$app->post('/paysafecard/capture_payment', [\App\Controllers\Payment\PaysafeCardController::class, 'postCapturePayment']);
$app->get('/paysafecard/capture_payment', [\App\Controllers\Payment\PaysafeCardController::class, 'getCapturePayment']);