<?php

namespace Proletariat;

class Config
{
    public static function get($config)
    {
        return self::loadConfig($config);
    }

    private static function loadConfig($config)
    {
        $configPath = explode('.', $config);

        if (self::cacheConfig()) {
            $cachedConfig = self::getCacheConfig($config);
            if ($cachedConfig !== null) {
                return $cachedConfig;
            }
        }
        
        $path = $_SERVER['DOCUMENT_ROOT'] . "/config/{$configPath[0]}.php";
        $configsArray = file_exists($path) ? require $path : throw new \RuntimeException('Could not find config file');
        $length = count($configPath);
        for ($i = 1; $i < $length; $i++) {
            if (is_array($configsArray) && array_key_exists($configPath[$i], $configsArray)) {
                $configsArray = $configsArray[$configPath[$i]];
            } else {
                throw new \RuntimeException('Could not find such key in config file');
            }
        }
    
        if (self::cacheConfig()) {
            self::setCacheConfig($config, $configsArray);
        }
        
        return $configsArray;
    }

    private static function getCacheConfig($config)
    {
        $configCache = require __DIR__ . '/../../config/cache.php';
        $cacheDir = __DIR__ . '/../../' . $configCache['file']['config']['path'];
        $file = $cacheDir . $configCache['file']['config']['name'] . '.php';
    
        if (file_exists($file)) {
            $data = require $file;
    
            if ($data['expiration'] > time() && isset($data[$config])) {
                return $data[$config];
            }
        }
    
        return null;
    }

    private static function setCacheConfig($key, $value)
    {
        $configCache = require __DIR__ . '/../../config/cache.php';
        
        $cacheDir = __DIR__ . '/../../' . $configCache['file']['config']['path'];
    
        $expiration = $configCache['file']['config']['expire'];
            
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0777, true);
        }
    
        $file = $cacheDir . $configCache['file']['config']['name'] . '.php';
        if (file_exists($file)) {
            $path = require $file;
            
            if (!is_array($path)) {
                $path = [];
            }
    
            if (isset($path[$key])) {
                return;
            }
    
            $path[$key] = $value;
            $path['expiration'] = time() + $expiration;
            file_put_contents($file, '<?php return ' . var_export($path, true) . ';');
            return;
        }
    
        $data = [
            $key => $value,
            'expiration' => time() + $expiration,
        ];
    
        file_put_contents($file, '<?php return ' . var_export($data, true) . ';');
    }

    private static function cacheConfig(): bool
    {
        $cacheConfig = require $_SERVER['DOCUMENT_ROOT'] . '/config/cache.php';
        return (bool)$cacheConfig['config'];
    }
}
