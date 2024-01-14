<?php

namespace Core;

use DI\ContainerBuilder;

class AppContainer
{
    public static function buildContainer()
    {
        $containerBuilder = new ContainerBuilder();
        self::registerProviders($containerBuilder);
        return $containerBuilder->build();
    }

    private static function registerProviders(ContainerBuilder $containerBuilder)
    {
        $providers = require($_SERVER['DOCUMENT_ROOT'] . '/config/providers.php');

        foreach ($providers as $provider) {
            $provider::register($containerBuilder);
        }
    }
}
