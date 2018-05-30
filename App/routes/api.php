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
$app->get('/payment/get_url', [\App\Controllers\Payment\PaysafeCardController::class, 'getUrl']);
$app->post('/payment/capture_payment', [\App\Controllers\Payment\PaysafeCardController::class, 'capturePayment']);