<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/baseUrl.php';

use App\Controllers\AuthController;
use App\Controllers\ProductController;
use App\Support\Router;

$router = new Router();

$router->get(BASE_URL . '/', fn() => require_once '../view/welcome.php');
$router->get(BASE_URL . '/shop', fn() => require_once '../view/shop.php');
$router->get(BASE_URL . '/product', ProductController::class . '::permalink');
$router->get(BASE_URL . '/cart', fn() => require_once '../view/cart.php');
$router->get(BASE_URL . '/checkout', fn() => require_once '../view/checkout.php');

// Auth
$router->get(BASE_URL . '/login', fn() => require_once '../view/auth/login.php');
$router->get(BASE_URL . '/register', fn() => require_once '../view/auth/register.php');
$router->post(BASE_URL . '/login-user', AuthController::class . '::handleLogin');
$router->post(BASE_URL . '/register-user', AuthController::class . '::handleRegistration');
$router->post(BASE_URL . '/logout', AuthController::class . '::handleLogout');

// Admin
$router->get(BASE_URL . '/admin', fn() => require_once '../view/admin/welcome.php');
$router->post(BASE_URL . '/admin/create-product/send', ProductController::class . '::create');

$router->addNotFoundHandler(fn() => require_once '../view/404.php');

$router->run();