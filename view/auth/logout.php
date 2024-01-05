<?php

require_once '../../vendor/autoload.php';
require_once __DIR__.'/../../config/baseUrl.php';
use App\models\Auth;

if (!Auth::isLogged()) {
    header('Location: '.BASE_URL.'view/index.php');
    exit();
}


Auth::logout();