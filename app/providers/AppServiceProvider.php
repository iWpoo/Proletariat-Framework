<?php

namespace App\Providers;

use DI\ContainerBuilder;
use App\Services\MyService;
use App\Services\ConsoleService;
use App\Services\ServiceInterface;

class AppServiceProvider
{
    public static function register(ContainerBuilder $containerBuilder)
    {        
        $containerBuilder->addDefinitions([
            ServiceInterface::class => function ($container) {
                return new ConsoleService();
            },
        ]);
    }
}
