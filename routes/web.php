<?php 

use Core\Router;
use Core\Route;

Router::addRoute(Route::get('/', 'index', 'index')->name('index'));
Router::addRoute(Route::post('/store', 'index', 'store')->name('store'));