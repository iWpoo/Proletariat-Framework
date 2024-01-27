<?php 

namespace Core;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{
    private static $instance;
    private static $capsule;

    public static function getInstance(array $config)
    {
        if (!self::$instance) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    private function __construct(array $config)
    {
        $this->init($config);
    }

    private function init(array $config)
    {
        try {
            if (!self::$capsule) {
                self::$capsule = new Capsule;
            }

            self::$capsule->addConnection($config);

            self::$capsule->setAsGlobal();
            self::$capsule->bootEloquent();
        } catch (\Exception $e) {
            throw new \Exception('Database connection error: ' . $e->getMessage());
        }
    }
}
