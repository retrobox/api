<?php

use App\NotFoundHandler;
use App\NotAllowedHandler;
use App\Utils\LaPoste;
use App\Utils\MailChimp;
use App\Utils\WebSocketServerClient;
use DI\Container;
use DiscordHandler\DiscordHandler;
use Illuminate\Database\Capsule\Manager;
use Monolog\Logger;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Psr\Container\ContainerInterface;
use SebastianWalker\Paysafecard\Client;
use SebastianWalker\Paysafecard\Urls;

return [
    'settings.debug' => true,

    Logger::class => function (ContainerInterface $container) {
        $log = new Monolog\Logger($container->get('app_name'));

        $log->pushHandler(new Monolog\Handler\StreamHandler($container->get('log')['path'], $container->get('log')['level']));

        if ($container->get('log')['discord']) {
            $log->pushHandler(new DiscordHandler(
                $container->get('log')['discord_webhooks'],
                $container->get('app_name'),
                $container->get('env_name'),
                $container->get('log')['level']
            ));
        }

        return $log;
    },

    Manager::class => function (Container $container) {
        $capsule = new Manager;
        $capsule->addConnection($container->get('mysql'));

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return $capsule;
    },

    Client::class => function (Container $container) {
        $client = new Client($container->get('paysafecard')['api_key']);

        $client->setTestingMode($container->get('paysafecard')['testing_mode']);
        $client->setUrls(new Urls(
            $container->get('paysafecard')['urls'][0],
            $container->get('paysafecard')['urls'][1],
            $container->get('paysafecard')['urls'][2]
        ));

        return $client;
    },

    \STAILEUAccounts\Client::class => function (Container $container) {
        return new \STAILEUAccounts\Client($container->get('staileu')['public'], $container->get('staileu')['private']);
    },

    ApiContext::class => function (ContainerInterface $container) {
        return new ApiContext(
            new OAuthTokenCredential($container->get('paypal')['public'], $container->get('paypal')['private'])
        );
    },

    MailChimp::class => function (ContainerInterface $container) {
        return new MailChimp($container->get('mailchimp')['api_key']);
    },

    \Predis\Client::class => function (ContainerInterface $container) {
        $hasPassword = !empty($container->get('redis')['password']);
        $params = [];
        if ($hasPassword) {
            $params = ['password' => $container->get('redis')['password']];
        }
        return new \Predis\Client($container->get('redis')['uri'], [
            'parameters' => $params,
            'prefix' => $container->get('redis')['prefix']
        ]);
    },

    WebSocketServerClient::class => function (ContainerInterface $container) {
        return new WebSocketServerClient(
            $container->get('jwt')['key'],
            $container->get('services')['websocket_server_endpoint']
        );
    },

    \Lefuturiste\Jobatator\Client::class => function (ContainerInterface $container) {
        $client = new Lefuturiste\Jobatator\Client(
            $container->get('jobatator')['host'],
            $container->get('jobatator')['port'],
            $container->get('jobatator')['username'],
            $container->get('jobatator')['password'],
            $container->get('jobatator')['group']
        );
        $client->createConnexion();
        return $client;
    },

    LaPoste::class => function (ContainerInterface $container) {
        return new LaPoste($container->get('la_poste')['key']);
    }
];
