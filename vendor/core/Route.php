<?php

namespace Core;
	
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

    public function name($name)
    {
        $this->name = $name;
        self::$routes[$name] = $this;
        return $this;
    }

    public static function getRoutes()
    {
        return self::$routes;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function __get($property)
    {
        return $this->$property;
    }
}
