<?php

use Core\Env;

return [
    'default' => Env::get('CACHE_DRIVER'),
    
    'route' => true,
    'config' => true,

    'file' => [
        'path' => '/storage/cache/',
        'expire' => 3600,
    ]
];