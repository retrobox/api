<?php
/*
|--------------------------------------------------------------------------
| Debug mode
|--------------------------------------------------------------------------
|
| If debug mode is enabled, we can enable tracy debugger
|
*/
/*
|--------------------------------------------------------------------------
| Debug and die function
|--------------------------------------------------------------------------
|
| Many time you need a simple function for debugging your application.
| This function will show to you the value parsed in html with Tracy Debugger library.
| This function is ignored is debug mode is not enabled
|
*/
function di($value = 'Die and Debug ! ;)')
{
	if (getenv('APP_DEBUG')){
		Tracy\Debugger::dump($value);
		die();
	}
};

function debug($value = 'Die and Debug ! ;)')
{
	return di($value);
}

function d($value = 'Die and Debug ! ;)')
{
	return di($value);
}

/*
|--------------------------------------------------------------------------
| Get environnement var and default is is null
|--------------------------------------------------------------------------
*/
function envOrDefault($value, $default = NULL){
	if (getenv($value) == false || getenv($value) == '' || empty(getenv($value))){
		return $default;
	}else{
		return getenv($value);
	}
}
