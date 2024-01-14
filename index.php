<?php

namespace Core;

require_once __DIR__ . '/vendor/libs/autoload.php';

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'on');

require_once $_SERVER['DOCUMENT_ROOT'] . '/database/connection.php';

$container = AppContainer::buildContainer();

$router = $container->get('Router');
$dispatcher = $container->get('Dispatcher');

$routes = require $_SERVER['DOCUMENT_ROOT'] . '/routes/routes.php';

$track = $router->getTrack($routes, $_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
$page = $dispatcher->getPage($track);

echo $page;
