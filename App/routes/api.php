<?php
/*
|--------------------------------------------------------------------------
| Api routing
|--------------------------------------------------------------------------
|
| Register it all your api routes
|
*/
$app->get('/', [\App\Controllers\PagesController::class, 'getHome']);
$app->post('/graphql', [\App\Controllers\GraphQlController::class, 'newRequest']);
$app->get('/paysafecard/get_url', [\App\Controllers\Payment\PaysafeCardController::class, 'getUrl']);
$app->post('/paysafecard/capture_payment', [\App\Controllers\Payment\PaysafeCardController::class, 'postCapturePayment']);
$app->get('/paysafecard/success', [\App\Controllers\Payment\PaysafeCardController::class, 'getSuccess']);
$app->get('/paysafecard/failure', [\App\Controllers\Payment\PaysafeCardController::class, 'getFailure']);