<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/routes.php';

use App\Controllers\ProductController;

$request_uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);

$request_uri = $request_uri_parts[0];
$query_string = isset($request_uri_parts[1]) ? $request_uri_parts[1] : null;

if (empty($query_string)) {
    $route = $routes[$request_uri] ?? '404.php';
    include __DIR__ . '/../view/' . $route;
    exit();
}

if (isset($_GET['product_id'])) {
    $productController = new ProductController();
    $productController->displayProductPage();
}