<?php

namespace Core;
	
class Router
{
    private static $routes = [];

    public static function addRoute(Route $route)
    {
        $key = $route->getMethod() . '|' . $route->getPath();
        self::$routes[$key] = $route;
    }

    public function getTrack($uri, $method)
    {
        $key = $method . '|' . $uri;

        if (isset(self::$routes[$key])) {
            $route = self::$routes[$key];
            return new Track($route->getController(), $route->getAction());
        }

        return new Track('error', 'notFound');
    }

    public function getRoutes()
    {
        return self::$routes;
    }
}
