<?php

use App\App;

return [
    'app_name' => $_ENV['APP_NAME'],
    'app_debug' => boolval($_ENV['APP_DEBUG']),
    'app_test' => boolval($_ENV['APP_TEST']),
    'env_name' => $_ENV['APP_ENV_NAME'],
    'log' => [
        'level' => $_ENV['LOG_LEVEL'],
        'discord' => $_ENV['LOG_DISCORD'],
        'discord_webhooks' => [
            $_ENV['LOG_DISCORD_WH']
        ],
        'path' => $_ENV['LOG_PATH']
    ],
    'locales' => [
        'fr',
        'en'
    ],
    'services' => [
        'web_endpoint' => $_ENV['WEB_ENDPOINT'],
        'admin_endpoint' => $_ENV['ADMIN_ENDPOINT'],
        'websocket_server_endpoint' => $_ENV['WEBSOCKET_SERVER_ENDPOINT'],
        'data_endpoint' => $_ENV['DATA_ENDPOINT'],
        'os_endpoint' => 'https://os.retrobox.tech'
    ],
    //staileu id of a default admin (super admin)
    'default_admin_user_id' => $_ENV['DEFAULT_ADMIN_USER_ID'],
    'master_api_key' => $_ENV['MASTER_API_KEY'],
    'mailchimp' => [
        'api_key' => $_ENV['MAILCHIMP_API_KEY'],
        'list_id' => $_ENV['MAILCHIMP_LIST_ID'],
        'discord_webhook' => $_ENV['MAILCHIMP_DISCORD_WH']
    ],
    'redis' => [
        'uri' => $_ENV['REDIS_URI'],
        'password' => $_ENV['REDIS_PASSWORD'],
        'prefix' => $_ENV['REDIS_PREFIX']
    ],
    'jobatator' => [
        'host' => $_ENV['JOBATATOR_HOST'],
        'port' => $_ENV['JOBATATOR_PORT'],
        'username' => $_ENV['JOBATATOR_USERNAME'],
        'password' => $_ENV['JOBATATOR_PASSWORD'],
        'group' => $_ENV['JOBATATOR_GROUP']
    ],
    'upload_path' => App::getBasePath() . '/' . $_ENV['UPLOAD_PATH']
];
