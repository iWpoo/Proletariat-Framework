<?php

namespace Proletariat;

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

    private static function registerProviders(ContainerBuilder $containerBuilder): void
    {
        $configFile = $_SERVER['DOCUMENT_ROOT'] . '/config/app.php';

        if (file_exists($configFile)) {
            $providers = require $configFile;

            foreach ($providers['providers'] as $provider) {
                if (!class_exists($provider)) {
                    throw new \RuntimeException("Provider class not found: $provider");
                }

                $provider::register($containerBuilder);
            }
        } else {
            throw new \RuntimeException('Config file not found.');
        }
    }

    private static function registerSystemProviders(ContainerBuilder $containerBuilder): void
    {
        $containerBuilder->addDefinitions([
            'Router' => static function () {
                return new Router(require __DIR__ . '/../../routes/web.php');
            },
            'Dispatcher' => static function ($container) {
                return new Dispatcher($container);
            },
        ]);
    }
}
