<?php

require __DIR__ . '/../vendor/autoload.php';
require '../helpers.php';

use Framework\Router;

// Instantiate the router
$router = new Router(); 

// Get the routes
$routes = require basePath('routes.php');

// Get the current URI and HTTP method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Route the request
$router->route($uri, $method);