<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/routes.php';

$request_uri = $_SERVER['REQUEST_URI'];

$route = $routes[$request_uri] ?? '404.php';

include __DIR__ . '/../view/' . $route;
