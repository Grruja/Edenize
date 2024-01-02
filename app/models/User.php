<?php


namespace App\models;


use App\validations\UserValidation;
use Database\Database;

class User
{
    protected $database;
    private $validationErrors = [];

    public function __construct()
    {
        $this->database = new Database();
    }

    public function create($formData)
    {
        $validation = new UserValidation();
        $errors = $validation->validateCreateUser($formData);

        if ($errors == null) {
            $password = password_hash($formData['password'], PASSWORD_BCRYPT);

            $database = $this->database->getConnection();

            $stmt = $database->prepare("INSERT INTO users (full_name, username, email, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $formData['full_name'], $formData['username'], $formData['email'], $password);
            $result = $stmt->execute();

            if ($result) {
                $_SESSION['user_id'] = $stmt->insert_id;
                $_SESSION['alert_message'] = 'Your account is successfully created!';
            }

            $this->database->closeConnection();
            header('Location: index.php');
            exit();

        } else {
            $this->validationErrors = $errors;
        }
    }

    public function getValidationErrors()
    {
        if ($this->validationErrors != null) {
            return $this->validationErrors;

        } else return null;
    }
}