<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\ProductController;
use App\Support\Router;

$router = new Router();

$router->addRoute('GET', '/shop', function () {
    include '../view/shop.php';
    exit();
});

$router->addRoute('GET', '/product/:productId', function ($productId) {
    $productController = new ProductController();
    $productController->setProductPage($productId);
    include '../view/product.php';
    exit();
});

$router->matchRoute();