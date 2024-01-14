<?php

namespace Core;

use DI\ContainerBuilder;

class AppContainer
{
    public static function buildContainer()
    {
        $containerBuilder = new ContainerBuilder();
        self::registerSystemProviders($containerBuilder);
        self::registerProviders($containerBuilder);
        return $containerBuilder->build();
    }

    private static function registerProviders(ContainerBuilder $containerBuilder)
    {
        $providers = require($_SERVER['DOCUMENT_ROOT'] . '/config/app.php');

        foreach ($providers['dependencies'] as $provider) {
            $provider::register($containerBuilder);
        }
    }

    private static function registerSystemProviders(ContainerBuilder $containerBuilder)
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
