<?php

use App\App;

return [
    'app_name' => getenv('APP_NAME'),
    'app_debug' => boolval(getenv('APP_DEBUG')),
    'app_test' => boolval(getenv('APP_TEST')),
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
        'admin_endpoint' => getenv('ADMIN_ENDPOINT'),
        'websocket_server_endpoint' => getenv('WEBSOCKET_SERVER_ENDPOINT'),
        'data_endpoint' => getenv('DATA_ENDPOINT'),
        'os_endpoint' => 'https://os.retrobox.tech'
    ],
    //staileu id of a default admin (super admin)
    'default_admin_user_id' => getenv('DEFAULT_ADMIN_USER_ID'),
    'master_api_key' => getenv('MASTER_API_KEY'),
    'mailchimp' => [
        'api_key' => getenv('MAILCHIMP_API_KEY'),
        'list_id' => getenv('MAILCHIMP_LIST_ID'),
        'discord_webhook' => getenv('MAILCHIMP_DISCORD_WH')
    ],
    'redis' => [
        'uri' => getenv('REDIS_URI'),
        //'password' => getenv('REDIS_PASSWORD'),
        'prefix' => getenv('REDIS_PREFIX')
    ],
    'jobatator' => [
        'host' => getenv('JOBATATOR_HOST'),
        'port' => getenv('JOBATATOR_PORT'),
        'username' => getenv('JOBATATOR_USERNAME'),
        'password' => getenv('JOBATATOR_PASSWORD'),
        'group' => getenv('JOBATATOR_GROUP')
    ],
    'upload_path' => App::getBasePath() . '/' . getenv('UPLOAD_PATH')
];
