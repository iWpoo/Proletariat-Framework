<?php

namespace Core;
	
class Path
{
    public function route($name)
    {
        return \Core\Route::getRoutes()[$name]->path ?? null;
    }
}