<?php

namespace Core;

require_once __DIR__ . '/vendor/libs/autoload.php';

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'on');

// Initialize the database
$database = new \Core\Database();

// Initializing the Dependency Container
$container = AppContainer::buildContainer();

// Processing routes
$router = $container->get('Router');
require $_SERVER['DOCUMENT_ROOT'] . '/routes/routes.php';
$dispatcher = $container->get('Dispatcher');    
$track = $router->getTrack($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
$page = $dispatcher->getPage($track);

// Page output
echo $page;
