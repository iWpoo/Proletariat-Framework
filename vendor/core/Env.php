<?php

namespace Proletariat;

class Env
{
    protected static $data;

    protected static function load(string $filePath = '.env')
    {
        $cachedEnv = self::getCacheConfig();
        $envFile = realpath(__DIR__ . '/../../' . $filePath);
    
        if ($cachedEnv === null || (file_exists($envFile) && filemtime($envFile) > $cachedEnv['mtime'])) {
            $parseIniFile = ($envFile !== false && file_exists($envFile)) ? parse_ini_file($envFile) : [];
            self::$data = $parseIniFile;
            self::setCacheEnv($parseIniFile);
        } else {
            self::$data = $cachedEnv['value'];
        }
    }

    public static function get(string $key, $default = null)
    {
        self::load();

        return self::$data[$key] ?? $default;
    }

    private static function getCacheConfig()
    {
        $cacheDir = __DIR__ . '/../../storage/app/';
        $file = $cacheDir . 'env.cache';

        if (file_exists($file)) {
            $data = unserialize(file_get_contents($file));

            if ($data['expiration'] > time()) {
                return [
                    'mtime' => filemtime($file),
                    'value' => $data['value']
                ];
            }
        }

        return null;
    }

    private static function setCacheEnv($value)
    {
        $cacheDir = __DIR__ . '/../../storage/app/';

        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0777, true);
        }

        $file = $cacheDir . 'env.cache';
        $data = [
            'value' => $value,
            'expiration' => time() + 86400 * 30,
        ];
        file_put_contents($file, serialize($data));
    }
}
