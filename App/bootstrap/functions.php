<?php
/*
|--------------------------------------------------------------------------
| Get environment var and default is is null
|--------------------------------------------------------------------------
*/
function envOrDefault($value, $default = NULL){
	if (getenv($value) == false || getenv($value) == '' || empty(getenv($value))){
		return $default;
	}else{
		return getenv($value);
	}
}
