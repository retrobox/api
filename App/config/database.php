<?php
return  [
	'mysql' => [
		'driver' => 'mysql',
		'host' => $_ENV['MYSQL_HOST'],
		'username' => $_ENV['MYSQL_USERNAME'],
		'password' => $_ENV['MYSQL_PASSWORD'],
		'database' => $_ENV['MYSQL_DATABASE'],
		// 'port' => $_ENV['MYSQL_PORT'],
		'charset'   => 'utf8',
		'collation' => 'utf8_unicode_ci',
		'prefix'    => '',
	]
];
