<?php


namespace App\Support;


class Session
{
    public static function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function userStart($userId)
    {
        self::start();
        $_SESSION['user_id'] = $userId;
    }

    public static function delete()
    {
        self::start();
        session_unset();
    }
}