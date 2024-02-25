<?php

use Proletariat\Support\Redirect;
use Proletariat\Support\Cache;
use Proletariat\Support\Config;
use Proletariat\Support\Env;

function redirect($to = null): Redirect
{
    return Redirect::redirect($to);
}

function cache()
{
    return Cache::getCacheObject();
}

function config($config)
{
    return Config::get($config);
}

function env($key, $default = null)
{
    return Env::get($key, $default);
}