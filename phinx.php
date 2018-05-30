<?php
chdir('public');
require 'index.php';

return [
	'paths' => [
		'migrations' => '%%PHINX_CONFIG_DIR%%/App/Database/Migrations',
		'seeds' =>  '%%PHINX_CONFIG_DIR%%/App/Database/Seeds'
	],
	'environments' => [
		'default_database' => 'development',
		'development' => [
			'adapter' => 'mysql',
			'host' => $app->getContainer()->get('mysql')['host'],
			'name' => $app->getContainer()->get('mysql')['database'],
			'user' => $app->getContainer()->get('mysql')['username'],
			'pass' => $app->getContainer()->get('mysql')['password'],
		]
	]
];