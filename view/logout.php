<?php

require_once '../vendor/autoload.php';
use App\models\User;

if (!User::isLogged()) {
    header('Location: index.php');
    exit();
}


User::logout();