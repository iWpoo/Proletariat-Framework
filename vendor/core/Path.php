<?php

namespace Core;
	
class Path
{
    public function route($name)
    {
        foreach (\Core\Route::getRoutes() as $route) {
            if ($route->name === $name) {
                return $route->path;
            }
        }
        return null;
    }
}