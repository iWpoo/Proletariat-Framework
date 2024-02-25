<?php

namespace Proletariat\Support\Cache;

use Proletariat\Support\Cache\iCache;
use Predis\Client;
use Proletariat\Support\Env;

class RedisCache implements ICache
{
    private $redis;
    private $configCache;

    public function __construct()
    {
        $this->redis = new Client([
            'host' => Env::get('REDIS_HOST'),
            'port' => Env::get('REDIS_PORT'),
            'password' => Env::get('REDIS_PASSWORD')
        ]);
        $this->configCache = require __DIR__ . '/../../../config/cache.php';
    }

    public function set($key, $value, $expiration = null) 
    {
        if ($expiration !== null) {
            $this->redis->setex($key, $expiration, $value);
            return;
        }

        $expiration = $this->configCache['file']['expire'];
        if ($expiration !== null) {
            $this->redis->setex($key, $expiration, $value);
            return;
        }

        $this->redis->set($key, $value);
    }

    public function get($key) 
    {
        return $this->redis->get($key);
    }

    public function delete($key) 
    {
        $this->redis->del($key);
    }

    public function exists($key)
    {
        $this->redis->exists($key);
    }
}
