<?php


namespace App\Services;

use App\Services\ServiceInterface;

class MyService implements ServiceInterface
{
    public function doSomething()
    {
        return "Service is doing something.";
    }
}
