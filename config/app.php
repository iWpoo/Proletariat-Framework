<?php 

use Core\Env;

return [
    'providers' => [
        \App\Providers\AppServiceProvider::class,
    ],

    'commands' => [
        \App\Console\Commands\RouteCache::class,
        \App\Console\Commands\ConfigCache::class,
        \App\Console\Commands\ClearCache::class,
    ]
];