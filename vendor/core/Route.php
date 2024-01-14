<?php

namespace Core;
	
// Route.php
class Route
{
    private $path;
    private $controller;
    private $action;
    private $method;
	private $name;
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
        return self::$routes[] = new self($path, $controller, $action, 'GET');
    }

    public static function post($path, $controller, $action)
    {
        return self::$routes[] = new self($path, $controller, $action, 'POST');
    }

	public static function put($path, $controller, $action)
    {
        return self::$routes[] = new self($path, $controller, $action, 'PUT');
    }

    public static function delete($path, $controller, $action)
    {
        return self::$routes[] = new self($path, $controller, $action, 'DELETE');
    }

	public function name($name)
    {
        $this->name = $name;
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

    public function __get($property)
    {
        return $this->$property;
    }
}
