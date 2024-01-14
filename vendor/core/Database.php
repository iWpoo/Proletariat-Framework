<?php 

namespace Core;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database {
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        $capsule = new Capsule;

        $capsule->addConnection(require($_SERVER['DOCUMENT_ROOT'] . '/config/database.php'));

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}