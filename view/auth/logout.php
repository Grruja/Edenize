<?php

require_once '../../vendor/autoload.php';
require_once __DIR__.'/../../config/baseUrl.php';
use App\Models\Auth;

if (!Auth::check()) {
    header('Location: '.BASE_URL.'view/index.php');
    exit();
}


Auth::logout();