<?php

use Psr\Container\ContainerInterface;

return [
	'settings.displayErrorDetails' => function (ContainerInterface $container) {
		return $container->get('app_debug');
	},
	'settings.debug' => function (ContainerInterface $container) {
		return $container->get('app_debug');
	},

	'notFoundHandler' => function (ContainerInterface $container) {
		return new \App\NotFoundHandler();
	},

	\Monolog\Logger::class => function (ContainerInterface $container) {
		$log = new Monolog\Logger($container->get('app_name'));

		$log->pushHandler(new Monolog\Handler\StreamHandler($container->get('log')['path'], $container->get('log')['level']));

		if ($container->get('log')['discord']) {
			$log->pushHandler(new \DiscordHandler\DiscordHandler(
				$container->get('log')['discord_webhooks'],
				$container->get('app_name'),
				$container->get('env_name'),
				$container->get('log')['level']
			));
		}

		return $log;
	},

	\Illuminate\Database\Capsule\Manager::class => function (\DI\Container $container) {
		$capsule = new \Illuminate\Database\Capsule\Manager;
		$capsule->addConnection($container->get('mysql'));

		$capsule->setAsGlobal();
		$capsule->bootEloquent();

		return $capsule;
	},

	\SebastianWalker\Paysafecard\Client::class => function (\DI\Container $container) {
		$client = new \SebastianWalker\Paysafecard\Client($container->get('paysafecard')['api_key']);

		$client->setTestingMode($container->get('paysafecard')['testing_mode']);
		$client->setUrls(new \SebastianWalker\Paysafecard\Urls($container->get('paysafecard')['urls'][0]), new \SebastianWalker\Paysafecard\Urls($container->get('paysafecard')['urls'][1]), new \SebastianWalker\Paysafecard\Urls($container->get('paysafecard')['urls'][2]));

		return $client;
	}
];
