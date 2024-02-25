<?php

use Proletariat\Support\Redirect;
use Proletariat\Support\Cache;
use Proletariat\Support\Config;
use Proletariat\Support\Env;


if (! function_exists('redirect')) {
    function redirect($to = null): Redirect
    {
        return Redirect::redirect($to);
    }
}

if (! function_exists('cache')) {
    function cache()
    {
        return Cache::getCacheObject();
    }
}

if (! function_exists('config')) {
    function config($config)
    {
        return Config::get($config);
    }
}

// function env($key, $default = null)
// {
//     return Env::get($key, $default);
// }
