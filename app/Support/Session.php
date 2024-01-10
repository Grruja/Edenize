<?php


namespace App\Support;


class Session
{
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function userStart($userId)
    {
        $_SESSION['user_id'] = $userId;
    }

    public static function userDestroy()
    {
        unset($_SESSION['user_id']);
    }
}