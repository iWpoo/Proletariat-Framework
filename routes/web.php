<?php 

use Core\Route;

$routes = [
    Route::get('/', 'index', 'index')->name('index'),
    Route::post('/store', 'index', 'store')->name('store'),
];
