<?php

namespace Proletariat;

// Include the autoloader
require_once __DIR__ . '/vendor/libs/autoload.php';

// Set up error reporting
error_reporting(E_ALL);
ini_set('display_errors', 'on');

try {
    // Initialize the database
    $databaseConfig = require_once(__DIR__ . '/config/database.php');
    $database = DatabaseManager::getInstance(new \Proletariat\Services\Eloquent)->initializeDatabase($databaseConfig);

    // Initialize the dependency container
    $container = AppContainer::buildContainer();

    // Process routes
    $router = $container->get('Router');

    // Dispatch the request
    $dispatcher = $container->get('Dispatcher');  
    $track = $router->getTrack($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    $page = $dispatcher->getPage($track);
    
    // Output the page
    echo $page;
} catch (\Exception $e) {
    // Handle errors and display error information
    echo 'An error occurred: ' . $e->getMessage();
}
