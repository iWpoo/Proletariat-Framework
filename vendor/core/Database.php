<?php 

namespace Core;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{
    public function __construct(array $config)
    {
        $this->init($config);
    }

    private function init(array $config)
    {
        try {
            $capsule = new Capsule;

            $capsule->addConnection($config);

            $capsule->setAsGlobal();
            $capsule->bootEloquent();
        } catch (\Exception $e) {
            throw new \Exception('Database connection error: ' . $e->getMessage());
        }
    }
}