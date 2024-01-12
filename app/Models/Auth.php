<?php


namespace App\Models;


require_once __DIR__.'/../../config/baseUrl.php';

use App\Support\Session;
use App\Validations\AuthValidation;
use Database\Database;

class Auth
{
    protected $database;
    private $validationErrors = [];

    public function __construct()
    {
        $this->database = new Database();
    }

    public function create($formData)
    {
        $validation = new AuthValidation();
        $errors = $validation->validateCreateUser($formData);

        if ($errors == null) {
            $password = password_hash($formData['password'], PASSWORD_BCRYPT);

            $dbConnection = $this->database->getConnection();

            $stmt = $dbConnection->prepare("INSERT INTO users (full_name, username, email, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssss', $formData['full_name'], $formData['username'], $formData['email'], $password);
            $result = $stmt->execute();

            if ($result) {
                Session::userStart($stmt->insert_id);
                $_SESSION['alert_message'] = 'Your account is successfully created!';
            }

            $this->database->closeConnection();
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
        $dbConnection = $this->database->getConnection();

        $stmt = $dbConnection->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();

        $result = $stmt->get_result();
        $this->database->closeConnection();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                Session::userStart($user['id']);
                $_SESSION['alert_message'] = 'Welcome back!';
                header('Location: '.BASE_URL.'view/index.php');
                exit();
            }
        }
        $this->validationErrors = ['login' => 'Incorrect username or password.'];
    }

    public static function check()
    {
        session_status() == PHP_SESSION_NONE ? session_start() : null;
        if (isset($_SESSION['user_id'])) {
            return true;
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