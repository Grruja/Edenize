<?php
require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/../../config/baseUrl.php';
use App\Models\Auth;
use App\Support\Session;
use App\Validations\AuthValidation;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $validation = new AuthValidation();
    $isValid = $validation->registerValidation($_POST);

    if (!$isValid) {
        Session::start();
        $_SESSION['errors'] = $validation->getValidationErrors();
        header('Location: '.BASE_URL.'view/auth/register.php');
        exit();
    }

    $user = new Auth();
    $user->create($_POST);

    header('Location: '.BASE_URL.'view/index.php');
    exit();
}