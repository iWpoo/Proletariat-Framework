<?php 

return [
    'providers' => [
        \App\Providers\AppServiceProvider::class,
    ],

    'commands' => [
        \App\Console\Commands\RouteCache::class,
        \App\Console\Commands\ConfigCache::class,
        \App\Console\Commands\ClearCache::class,
        \App\Console\Commands\StartServer::class,
    ]
];