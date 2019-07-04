<?php
return [
	'app_name' => getenv('APP_NAME'),
	'app_debug' => (getenv('APP_DEBUG') ? true : false),
	'env_name' => getenv('APP_ENV_NAME'),
	'log' => [
		'level' => getenv('LOG_LEVEL'),
		'discord' => getenv('LOG_DISCORD'),
		'discord_webhooks' => [
			getenv('LOG_DISCORD_WH')
		],
		'path' => getenv('LOG_PATH')
	],
    'locales' => [
        'fr',
        'en'
    ],
    'services' => [
        'web_endpoint' => getenv('WEB_ENDPOINT'),
        'docs_endpoint' => getenv('DOCS_ENDPOINT'),
        'websocket_server_endpoint' => getenv('WEBSOCKET_SERVER_ENDPOINT')
    ],
    //staileu id of a default admin (super admin)
    'default_admin_user_id' => getenv('DEFAULT_ADMIN_USER_ID'),
    'master_api_key' => getenv('MASTER_API_KEY'),
    'rabbitmq' => [
        'host' => getenv('RABBITMQ_HOST'),
        'port' => getenv('RABBITMQ_PORT'),
        'username' => getenv('RABBITMQ_USERNAME'),
        'password' => getenv('RABBITMQ_PASSWORD'),
        'virtual_host' => getenv('RABBITMQ_VIRTUAL_HOST')
    ],
    'mailchimp' => [
        'api_key' => getenv('MAILCHIMP_API_KEY'),
        'list_id' => getenv('MAILCHIMP_LIST_ID'),
        'discord_webhook' => getenv('MAILCHIMP_DISCORD_WH')
    ],
    'redis' => [
        'uri' => getenv('REDIS_URI'),
        'password' => getenv('REDIS_PASSWORD'),
        'prefix' => getenv('REDIS_PREFIX')
    ]
];
