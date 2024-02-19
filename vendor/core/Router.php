<?php

namespace Proletariat;
	
class Router
{   
    private array $routes;

    public function __construct(array $routes)
    {
        $this->initializeRoutes($routes);
    }

    private function initializeRoutes(array $routes): void
    {
        if ($this->cacheRoute()) {
            $cachedRoutes = $this->getCacheRoute();

            if ($cachedRoutes !== null) {
                $this->routes = $cachedRoutes;
                return;
            }
        }

        $this->routes = $this->buildRoutes($routes);

        if ($this->cacheRoute()) {
            $this->setCacheRoute($this->routes);
        }
    }

    private function buildRoutes(array $routes): array
    {
        $builtRoutes = [];

        foreach ($routes as $route) {
            $key = $route->getMethod() . '|' . $route->getPath();
            $builtRoutes[$key] = $route;
        }

        return $builtRoutes;
    }

    public function getTrack(string $uri, string $method): Track
    {
        $key = $method . '|' . $uri;

        if (isset($this->routes[$key])) {
            $route = $this->routes[$key];
            return new Track($route->getController(), $route->getAction());
        }

        throw new \RuntimeException("Route not found for URI: $uri, Method: $method");
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    private function getCacheRoute()
    {
        $configCache = require __DIR__ . '/../../config/cache.php';
        $cacheDir = __DIR__ . '/../../' . $configCache['file']['route']['path'];
        $file = $cacheDir . $configCache['file']['route']['name'] . '.cache';
    
        if (file_exists($file)) {
            $data = unserialize(file_get_contents($file));
    
            if ($data['expiration'] > time()) {
                return $data['value'];
            }
        }
    
        return null;
    }

    private function setCacheRoute($value)
    {
        $configCache = require __DIR__ . '/../../config/cache.php';
        
        $cacheDir = __DIR__ . '/../../' . $configCache['file']['route']['path'];
    
        $expiration = $configCache['file']['route']['expire'];
            
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0777, true);
        }
    
        $file = $cacheDir . $configCache['file']['route']['name'] . '.cache';
        if (file_exists($file)) {
            $data = [
                'value' => $value,
                'expiration' => time() + $expiration,
            ];
            file_put_contents($file, serialize($data));
            return;
        }
    
        $data = [
            'value' => $value,
            'expiration' => time() + $expiration,
        ];
    
        file_put_contents($file, serialize($data));
    }

    private function cacheRoute(): bool
    {
        $cacheRoute = require $_SERVER['DOCUMENT_ROOT'] . '/config/cache.php';
        return (bool) $cacheRoute['route'];
    }
}
