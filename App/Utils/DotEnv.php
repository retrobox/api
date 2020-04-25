<?php

namespace App\Utils;

use App\App;

class DotEnv
{
    public static function load(): void
    {
        $base = App::getBasePath();
        $file = null;
        $isTest = boolval(getenv('APP_TEST'));
        if (file_exists($base . '/.env') && !$isTest)
            $file = '.env';
        if (file_exists($base . '/.env.test') && $isTest)
            $file = '.env.test';
        if ($file !== null) {
            $dotEnv = new \Dotenv\Dotenv($base, $file);
            $dotEnv->load();
        }
    }
}
