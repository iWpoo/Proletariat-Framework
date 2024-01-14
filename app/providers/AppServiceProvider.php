<?php

namespace App\Providers;

use Core\ProviderInterface;
use DI\ContainerBuilder;
use App\Services\MyService;
use App\Services\ServiceInterface;

class AppServiceProvider implements ProviderInterface
{
    public static function register(ContainerBuilder $containerBuilder)
    {        
        $containerBuilder->addDefinitions([
            ServiceInterface::class => function ($container) {
                return new MyService();
            },
        ]);
    }
}
