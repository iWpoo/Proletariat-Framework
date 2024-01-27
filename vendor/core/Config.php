<?php

namespace Core;

class Config
{
    public static function get($config)
    {
        if (self::cacheConfig()) {
            $cachedConfig = Cache::get($config);
            if ($cachedConfig !== null) {
                return $cachedConfig;
            }
        }

        $configArray = self::loadConfig($config);

        if (self::cacheConfig()) {
            Cache::set($config, $configArray, 86400 * 30);
        }

        return $configArray;
    }

    private static function loadConfig($config)
    {
        $configPath = explode('.', $config);
        $path = $_SERVER['DOCUMENT_ROOT'] . "/config/{$configPath[0]}.php";

        $configArray = file_exists($path) ? require $path : throw new \RuntimeException('Could not find config file');

        $length = count($configPath);
        for ($i = 1; $i < $length; $i++) {
            if (is_array($configArray) && array_key_exists($configPath[$i], $configArray)) {
                $configArray = $configArray[$configPath[$i]];
            } else {
                throw new \RuntimeException('Could not find such key in config file');
            }
        }

        return $configArray;
    }

    private static function cacheConfig(): bool
    {
        $cacheConfig = require $_SERVER['DOCUMENT_ROOT'] . '/config/cache.php';
        return (bool)$cacheConfig['config'];
    }
}
