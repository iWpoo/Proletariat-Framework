<?php

namespace Core;
	
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
            $cachedRoutes = Cache::get('cached_routes');

            if ($cachedRoutes !== null) {
                $this->routes = $cachedRoutes;
                return;
            }
        }

        $this->routes = $this->buildRoutes($routes);

        if ($this->cacheRoute()) {
            Cache::set('cached_routes', $this->routes, 86400 * 30);
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

    private function cacheRoute(): bool
    {
        $cacheRoute = require $_SERVER['DOCUMENT_ROOT'] . '/config/cache.php';
        return (bool) $cacheRoute['route'];
    }
}
