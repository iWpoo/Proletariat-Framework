<?php

use Core\Env;

return [
    'driver' => Env::get('DB_CONNECTION'),
    'host' => Env::get('DB_HOST'),
    'database' => Env::get('DB_DATABASE'),
    'username' => Env::get('DB_USERNAME'),
    'password' => Env::get('DB_PASSWORD'),
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => Env::get('DB_PREFIX'),
];