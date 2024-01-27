<?php

namespace Core;

class Env
{
    protected static $data;

    protected static function load(string $filePath = '.env'): void
    {
        if (!isset(self::$data)) {
            $envFile = $_SERVER['DOCUMENT_ROOT'] . '/' . $filePath;

            if (!file_exists($envFile)) {
                throw new \RuntimeException('.env file not found');
            }

            self::$data = parse_ini_file($envFile);
        }
    }

    public static function get(string $key, $default = null)
    {
        self::load();

        return self::$data[$key] ?? $default;
    }
}
