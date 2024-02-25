<?php

namespace Proletariat\Support;

use Proletariat\Support\Cache\FileCache;
use Proletariat\Support\Cache\RedisCache;

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

    public static function exists($key)
    {
        self::init();
        self::$cache->exists($key);
    }

    public static function getCacheObject(): self
    {
        return new self();
    }
}
