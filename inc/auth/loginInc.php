<?php
require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/../../config/baseUrl.php';
use App\Models\Auth;

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    header('Location: '.BASE_URL.'view/auth/login.php');
    exit();
}

$user = new Auth();
$login = $user->login($_POST['username'], $_POST['password']);

if (!$login) {
    header('Location: '.BASE_URL.'view/auth/login.php');
    exit();
}

header('Location: '.BASE_URL.'view/index.php');
exit();

