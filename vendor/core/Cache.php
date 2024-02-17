<?php

namespace Core;

class Cache 
{
    private static $configCache;
    private static $cacheDir;

    public static function init() 
    {
        self::$configCache = require __DIR__ . '/../../config/cache.php';
        
        if (self::$configCache['default'] == 'file') {
            self::$cacheDir = __DIR__ . '/../../' . self::$configCache['file']['path'];

            if (!is_dir(self::$cacheDir)) {
                mkdir(self::$cacheDir, 0777, true);
            }
        }
    }

    public static function set($key, $value, $expiration = null, bool $hash = true) 
    {
        self::init();
        
        $cacheFile = self::getCacheFilePath($key, $hash);

        $expiration = isset($expiration) ? $expiration : self::$configCache['file']['expire'];

        $data = [
            'value' => $value,
            'expiration' => time() + $expiration,
        ];

        file_put_contents($cacheFile, serialize($data));
    }

    public static function get($key, bool $hash = true) 
    {
        self::init();
        
        $cacheFile = self::getCacheFilePath($key, $hash);

        if (file_exists($cacheFile)) {
            $data = unserialize(file_get_contents($cacheFile));

            if ($data['expiration'] > time()) {
                return $data['value'];
            } else {
                unlink($cacheFile);
            }
        }

        return null;
    }

    public static function delete($key, bool $hash = true) 
    {
        self::init();
        
        $cacheFile = self::getCacheFilePath($key, $hash);

        if (file_exists($cacheFile)) {
            unlink($cacheFile);
        }
    }

    private static function getCacheFilePath($key, bool $hash = true) 
    {
        $key = $hash ? sha1($key) : $key;
        return self::$cacheDir . $key . '.cache';
    }
}
