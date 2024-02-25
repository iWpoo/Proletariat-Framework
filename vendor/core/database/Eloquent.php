<?php 

namespace Proletariat\Database;

use Proletariat\Database\iDatabase;
use Illuminate\Database\Capsule\Manager as Capsule;

class Eloquent implements iDatabase
{
    public function init(array $config)
    {
        try {
            $capsule = new Capsule;
            $capsule->addConnection($config);
            $capsule->setAsGlobal();
            $capsule->bootEloquent();
        } catch (\Exception $e) {
            throw new \Exception('Eloquent initialization error: ' . $e->getMessage());
        }
    }
}