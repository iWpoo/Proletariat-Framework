<?php

namespace Core;

class Config
{
    protected static $config;

    protected static function loadConfig()
    {
        $configFiles = glob($_SERVER['DOCUMENT_ROOT'] . '/config/*.php');

        foreach ($configFiles as $file) {
            $configName = pathinfo($file, PATHINFO_FILENAME);
            self::$config[$configName] = include $file;
        }
    }

    public static function get($key, $default = null)
    {
        self::loadConfig();
        return self::getValue(self::$config, explode('.', $key), $default);
    }

    protected static function getValue($config, $keys, $default)
    {
        foreach ($keys as $segment) {
            if (isset($config[$segment])) {
                $config = &$config[$segment];
            } else {
                return $default;
            }
        }

        return $config;
    }
}
