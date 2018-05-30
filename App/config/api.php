<?php
return [
	"paysafecard" => [
		"api_key" => getenv('PAYSAFECARD_API_KEY'),
		'testing_mode' => true,
		'urls' => [
			getenv('PAYSAFECARD_SUCCESS_URL'),
			getenv('PAYSAFECARD_FAILURE_URL'),
			getenv('PAYSAFECARD_NOTIFICATION_URL')
		]
	]
];