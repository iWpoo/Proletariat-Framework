<?php

use Proletariat\Support\Env;

return [    
    'driver' => Env::get('CACHE_DRIVER'),

    'route' => false,
    'config' => false,

    'file' => [
        'path' => 'storage/cache/',
        'expire' => null, // default time

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