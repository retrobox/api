<?php
return [
	'mysql' => [
		'driver' => 'mysql',
		'host' => getenv('MYSQL_HOST'),
		'username' => getenv('MYSQL_USERNAME'),
		'password' => getenv('MYSQL_PASSWORD'),
		'database' => getenv('MYSQL_DATABASE'),
		'charset'   => 'utf8',
		'collation' => 'utf8_unicode_ci',
		'prefix'    => '',
	]
];