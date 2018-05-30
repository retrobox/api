<?php
/*
|--------------------------------------------------------------------------
| Middleware requirements
|--------------------------------------------------------------------------
|
| Add Middleware to App
|
*/
/*
|--------------------------------------------------------------------------
| Whoops errors format
| Must be APP_DEBUG = true
|--------------------------------------------------------------------------
*/
if (getenv('APP_DEBUG')){
	$whoopsGuard = new \Zeuxisoo\Whoops\Provider\Slim\WhoopsGuard();
	$whoopsGuard->setApp($app);
	$whoopsGuard->setRequest($container->get('request'));
	$whoopsGuard->setHandlers([]);
	$whoopsGuard->install();
}