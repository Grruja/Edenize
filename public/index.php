<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/baseUrl.php';

use App\Controllers\ProductController;
use App\Support\Router;

$router = new Router();

$router->get(BASE_URL . '/', function () {
    require_once '../view/welcome.php';
});

$router->get(BASE_URL . '/shop', function () {
    require_once '../view/shop.php';
});

$router->get(BASE_URL . '/product', ProductController::class . '::permalink');

$router->addNotFoundHandler(function () {
    require_once '../view/404.php';
});

$router->run();