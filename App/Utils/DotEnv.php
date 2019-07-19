<?php

namespace App\Utils;

use App\App;

class DotEnv
{
    public static function load(): void
    {
        $base = App::getBasePath();
        if (file_exists($base . '/.env')) {
            $dotEnv = new \Dotenv\Dotenv($base);
            $dotEnv->load();
        }
    }
}
