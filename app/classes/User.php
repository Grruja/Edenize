<?php


namespace App\classes;


use App\classes\validations\UserValidation;
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

        if ($errors === null) {
            $password = password_hash($formData['password'], PASSWORD_BCRYPT);

            $database = $this->database->getConnection();

            $fullName = $database->real_escape_string($formData['full_name']);
            $username = $database->real_escape_string($formData['username']);
            $email = $database->real_escape_string($formData['email']);

            $database->query("
                INSERT INTO users 
                (full_name, username, email, password) 
                VALUES 
                ('$fullName', '$username', '$email', '$password')
            ");

            $this->database->closeConnection();

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