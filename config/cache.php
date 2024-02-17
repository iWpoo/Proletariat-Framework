<?php

use Core\Env;

return [
    'default' => Env::get('CACHE_DRIVER'),
    
    'route' => false,
    'config' => false,

    'file' => [
        'path' => 'storage/cache/',
        'expire' => 3600, // default time

        'config' => [
            'path' => 'storage/app/',
            'expire' => 86400 * 30,
            'name' => 'configs',
        ],

        'route' => [
            'path' => 'storage/app/',
            'expire' => 86400 * 30,
            'name' => 'routes',
        ],
    ]
];