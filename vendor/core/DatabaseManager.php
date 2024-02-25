<?php 

namespace Proletariat;

use Proletariat\Database\iDatabase;

class DatabaseManager
{
    private static $instance;
    private iDatabase $orm;

    private function __construct(iDatabase $orm)
    {
        $this->orm = $orm;
    }

    public static function getInstance(iDatabase $orm)
    {
        if (!self::$instance) {
            self::$instance = new self($orm);
        }

        return self::$instance;
    }

    public function initializeDatabase(array $config)
    {
        $this->orm->init($config);
    }
}