<?php


namespace App\Models;


require_once __DIR__.'/../../config/baseUrl.php';
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

    public function create(array $formData): void
    {
        $result = $this->authRepo->insertUser($formData);

        Session::userLogin($result->insert_id ?? null);
        $_SESSION['alert_message']['success'] = 'Your account is successfully created!';
    }

    public function login(string $username, string $password): bool
    {
        Session::start();

        if ($this->authRepo->userExists($username)) {
            $user = $this->authRepo->getUser($username);

            if (password_verify($password, $user['password'])) {
                Session::userLogin($user['id']);
                $_SESSION['alert_message']['success'] = 'Welcome back!';
                return true;
            }
        }
        $_SESSION['alert_message']['danger'] = 'Invalid username or password.';
        return false;
    }

    public static function isUserAdmin(): bool
    {
        if (Session::isUserLogged()) {
            $db = new Database();
            $result = $db->getConnection()->query("SELECT * FROM users WHERE id = {$_SESSION['user_id']} AND is_admin = 1");
            $db->closeConnection();

            if ($result->num_rows > 0) return true;
            return false;
        }
        return false;
    }
}