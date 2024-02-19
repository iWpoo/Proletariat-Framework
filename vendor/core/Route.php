<?php

namespace Proletariat;
	
class Route
{
    private $name;
    private $path;
    private $controller;
    private $action;
    private $method;
    private static $routes = [];

    private function __construct($path, $controller, $action, $method = 'GET')
    {
        $this->path = $path;
        $this->controller = $controller;
        $this->action = $action;
        $this->method = $method;
    }

    public static function get($path, $controller, $action)
    {
        return new self($path, $controller, $action, 'GET');
    }

    public static function post($path, $controller, $action)
    {
        return new self($path, $controller, $action, 'POST');
    }

    public static function put($path, $controller, $action)
    {
        return new self($path, $controller, $action, 'PUT');
    }

    public static function delete($path, $controller, $action)
    {
        return new self($path, $controller, $action, 'DELETE');
    }

    public function name($name): self
    {
        $this->name = $name;
        self::$routes[$name] = $this;
        return $this;
    }

    public static function getRoutes(): array
    {
        return self::$routes;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public static function route(string $name): ?string
    {
        return self::$routes[$name]->path ?? null;
    }   

    public function __get($property)
    {
        return $this->$property;
    }
}
