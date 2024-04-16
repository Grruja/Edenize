<?php


namespace App\Models;


use App\Repositories\AuthRepo;
use App\Support\Session;
use Database\Database;

class Auth
{
    private AuthRepo $authRepo;

    public function __construct()
    {
        $this->authRepo = new AuthRepo();
    }

    public function register(array $formData): void
    {
        $userId = $this->authRepo->insertUserReturnId($formData);
        Session::userLogin($userId ?? null);
    }

    public function login(string $username, string $password): bool
    {
        if (!$this->authRepo->userExists($username)) return false;

        $user = $this->authRepo->getUser($username);

        if (!password_verify($password, $user['password'])) return false;

        Session::userLogin($user['id']);
        return true;
    }

    public static function isUserAdmin(): bool
    {
        if (!Session::isUserLogged()) return false;

        $db = new Database();
        $result = $db->getConnection()->query("SELECT * FROM users WHERE id = {$_SESSION['user_id']} AND is_admin = 1");

        return $result->num_rows > 0;
    }
}