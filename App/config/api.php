<?php
return [
	"paysafecard" => [
		"api_key" => getenv('PAYSAFECARD_API_KEY'),
		'testing_mode' => true,
		'url' => getenv('PAYSAFECARD_NOTIFICATION_URL')
	]
];