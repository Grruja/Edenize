<?php

require_once '../database/Database.php';

class User
{
    protected $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function create($fullName, $username, $email, $password)
    {
        $hashPassword = password_hash($password, PASSWORD_BCRYPT);

        $database = $this->database->getConnection();
        $escFullName = $database->real_escape_string($fullName);
        $escUsername = $database->real_escape_string($username);
        $escEmail = $database->real_escape_string($email);

        $database->query("
            INSERT INTO users 
            (full_name, username, email, password) 
            VALUES 
            ('$escFullName', '$escUsername', '$escEmail', '$hashPassword')
        ");

        $this->database->closeConnection();
    }
}