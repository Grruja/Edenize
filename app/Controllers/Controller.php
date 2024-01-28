<?php


namespace App\Controllers;


require_once __DIR__.'/../../config/baseUrl.php';

class Controller
{
    protected function redirect(string $path): void
    {
        header('Location: '.BASE_URL.$path);
        exit();
    }

    protected function redirectTo404(): void
    {
        header('Location: '.BASE_URL.'/view/404.php');
        exit();
    }
}