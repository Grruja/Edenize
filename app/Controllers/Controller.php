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
        http_response_code(404);
        require_once __DIR__ . '/../../view/404.php';
        exit();
    }
}