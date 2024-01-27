<?php 

use Core\Route;

return [
    Route::get('/', 'index', 'index')->name('index'),
    Route::get('/about', 'index', 'about')->name('about'),
    Route::post('/store', 'index', 'store'),
];