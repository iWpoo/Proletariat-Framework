<?php 

namespace Core;

use Core\Services\Eloquent;

class Database
{
    private static $instance;

    public static function getInstance(array $config)
    {
        if (!self::$instance) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    private function __construct(array $config)
    {
        $orm_type = Env::get('ORM_DRIVER');
        switch ($orm_type) {
            case 'eloquent':
                return Eloquent::getInstance($config);
            default: 
                throw new \Exception('Undefined database type: ' . $orm_type);
        }
    }
}
