<?php
require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/../../config/baseUrl.php';
use App\Support\Session;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!Session::isUserLogged()) {
        header('Location: '.BASE_URL.'view/404.php');
        exit();
    }
    Session::userLogout();
    header('Location: '.BASE_URL.'view/auth/login.php');
    exit();

} else {
    header('Location: '.BASE_URL.'view/404.php');
    exit();
}
