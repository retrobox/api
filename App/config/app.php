<?php
return [
	'app_name' => getenv('APP_NAME'),
	'app_debug' => (envOrDefault('APP_DEBUG', 0) ? true : false),
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
        'web_endpoint' => getenv('WEB_ENDPOINT')
    ],
    //staileu id of a default admin (super admin)
    'default_admin_user_id' => getenv('DEFAULT_ADMIN_USER_ID')
];
