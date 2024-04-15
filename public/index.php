<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Support\Router;
use App\Support\Session;
use App\Controllers\AuthController;
use App\Controllers\CartController;
use App\Controllers\OrderController;
use App\Controllers\ProductController;

$baseUrl = '/live_projects/edenize';
$publicPath = '/live_projects/edenize/public';

Session::start();
$router = new Router();

$router->get($baseUrl . '/', fn() => require_once '../view/welcome.php');
$router->get($baseUrl . '/shop', fn() => require_once '../view/shop.php');
$router->get($baseUrl . '/product', ProductController::class . '::permalink');
$router->get($baseUrl . '/cart', fn() => require_once '../view/cart.php');
$router->get($baseUrl . '/checkout', fn() => require_once '../view/checkout.php');
$router->post($baseUrl . '/cart/add-product', CartController::class . '::addProduct');
$router->post($baseUrl . '/cart/remove-product', CartController::class . '::removeFromCart');
$router->post($baseUrl . '/order/send', OrderController::class . '::place');

// Auth
$router->get($baseUrl . '/login', fn() => require_once '../view/auth/login.php');
$router->get($baseUrl . '/register', fn() => require_once '../view/auth/register.php');
$router->post($baseUrl . '/login/send', AuthController::class . '::handleLogin');
$router->post($baseUrl . '/register/send', AuthController::class . '::handleRegistration');
$router->post($baseUrl . '/logout/send', AuthController::class . '::handleLogout');

// Admin
$router->get($baseUrl . '/admin', fn() => require_once '../view/admin/welcome.php');
$router->post($baseUrl . '/admin/create-product/send', ProductController::class . '::create');

$router->addNotFoundHandler(fn() => require_once '../view/404.php');

$router->run();