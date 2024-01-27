<?php

namespace Core;

class Cache 
{
    private static $configCache;
    private static $cacheDir;

    public static function init() 
    {
        self::$configCache = require $_SERVER['DOCUMENT_ROOT'] . '/config/cache.php';
        
        if (self::$configCache['default'] == 'file') {
            self::$cacheDir = $_SERVER['DOCUMENT_ROOT'] . self::$configCache['file']['path'];

            if (!is_dir(self::$cacheDir)) {
                mkdir(self::$cacheDir, 0777, true);
            }
        }
    }

    public static function set($key, $value, $expiration = null) 
    {
        self::init();
        
        $cacheFile = self::getCacheFilePath($key);

        $expiration = isset($expiration) ? $expiration : self::$configCache['file']['expire'];

        $data = [
            'value' => $value,
            'expiration' => time() + $expiration,
        ];

        file_put_contents($cacheFile, serialize($data));
    }

    public static function get($key) 
    {
        self::init();
        
        $cacheFile = self::getCacheFilePath($key);

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

    public static function delete($key) 
    {
        self::init();
        
        $cacheFile = self::getCacheFilePath($key);

        if (file_exists($cacheFile)) {
            unlink($cacheFile);
        }
    }

    private static function getCacheFilePath($key) 
    {
        $key = sha1($key);

        return self::$cacheDir . $key . '.cache';
    }
}
