<?php


namespace App\Models;


require_once __DIR__.'/../../config/baseUrl.php';

use App\Repositories\AuthRepo;
use App\Support\Session;
use App\Validations\AuthValidation;
use Database\Database;

class Auth
{
    protected $authRepo;
    private $validationErrors = [];

    public function __construct()
    {
        $this->authRepo = new AuthRepo();
    }

    public function create($formData)
    {
        $validation = new AuthValidation();
        $errors = $validation->validateCreateUser($formData);

        if ($errors == null) {
            $password = password_hash($formData['password'], PASSWORD_BCRYPT);

            $result = $this->authRepo->create($formData, $password);

            if ($result['execute']) {
                Session::userStart($result['stmt']->insert_id);
                $_SESSION['alert_message']['success'] = 'Your account is successfully created!';
            }

            header('Location: '.BASE_URL.'view/index.php');
            exit();

        } else {
            $this->validationErrors = $errors;
        }
    }

    public function getValidationErrors()
    {
        return $this->validationErrors;
    }

    public function login($username, $password)
    {
        if (!isset($username) || !isset($password)) {
            header('Location: '.BASE_URL.'view/auth/login.php');
            exit();
        }

        $result = $this->authRepo->login($username);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                Session::userStart($user['id']);
                $_SESSION['alert_message']['success'] = 'Welcome back!';
                header('Location: '.BASE_URL.'view/index.php');
                exit();
            }
        }
        $this->validationErrors = ['login' => 'Incorrect username or password.'];
    }

    public static function check()
    {
        Session::start();
        if (isset($_SESSION['user_id'])) {
            return true;
        }
        return false;
    }

    public static function adminCheck()
    {
        if (self::check()) {
            $db = new Database();
            $result = $db->getConnection()->query("SELECT * FROM users WHERE id = {$_SESSION['user_id']} AND is_admin = 1");
            $db->closeConnection();

            if ($result->num_rows > 0) return true;
            return false;
        }
        return false;
    }

    public static function logout()
    {
        Session::delete();
        header('Location: '.BASE_URL.'view/auth/login.php');
        exit();
    }
}