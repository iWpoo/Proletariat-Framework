<?php

namespace Core;

use DI\ContainerBuilder;

class ServiceProvider
{
    public static function register(ContainerBuilder $containerBuilder)
    {
        $containerBuilder->addDefinitions([
            'Router' => function () {
                return new Router();
            },
            'Dispatcher' => function ($container) {
                return new Dispatcher($container);
            },
        ]);
    }
}
