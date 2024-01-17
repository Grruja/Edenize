<?php

require_once '../../vendor/autoload.php';
require_once __DIR__.'/../../config/baseUrl.php';
use App\Models\Auth;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!Auth::check()) {
        header('Location: '.BASE_URL.'view/404.php');
        exit();
    }
    Auth::logout();

} else {
    header('Location: '.BASE_URL.'view/404.php');
    exit();
}