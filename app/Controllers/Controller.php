<?php


namespace App\Controllers;


class Controller
{
    protected function redirect(string $path): void
    {
        global $baseUrl;
        header('Location: '.$baseUrl.$path);
        exit();
    }

    protected function redirectTo404(): void
    {
        http_response_code(404);
        require_once __DIR__ . '/../../view/404.php';
        exit();
    }
}