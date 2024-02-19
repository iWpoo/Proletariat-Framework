<?php

namespace Proletariat;

use Proletariat\Services\FileCache;
use Proletariat\Services\RedisCache;

class Cache 
{
    private static $cache;

    public static function init()
    {
        $cacheConfig = require __DIR__ . '/../../config/cache.php';
        switch ($cacheConfig['driver']) {
            case 'file': 
                self::$cache = new FileCache();
                break;
            case 'redis':
                self::$cache = new RedisCache();
                break;
            default:
                throw new \Exception('Undefined cache type: ' . $cacheConfig['driver']);
        }
    }

    public static function set($key, $value, $expiration = null) 
    {
        self::init();
        self::$cache->set($key, $value, $expiration);
    }

    public static function get($key) 
    {
        self::init();
        return self::$cache->get($key);
    }

    public static function delete($key) 
    {
        self::init();
        self::$cache->delete($key);
    }

    public function exists($key)
    {
        self::init();
        self::$cache->exists($key);
    }
}
