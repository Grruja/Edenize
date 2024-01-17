<?php


namespace App\Repositories;


class AuthRepo extends Repository
{
    public function create($formData, $password)
    {
        $dbConnection = $this->database->getConnection();

        $stmt = $dbConnection->prepare("INSERT INTO users (full_name, username, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $formData['full_name'], $formData['username'], $formData['email'], $password);
        $execute = $stmt->execute();
        $this->database->closeConnection();

        return [
            'execute' => $execute,
            'stmt' => $stmt,
        ];
    }

    public function validateUniqueField($fieldName, $inputValue)
    {
        $dbConnection = $this->database->getConnection();

        $stmt = $dbConnection->prepare("SELECT * FROM users WHERE $fieldName = ?");
        $stmt->bind_param('s', $inputValue);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function login($username)
    {
        $dbConnection = $this->database->getConnection();

        $stmt = $dbConnection->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        $this->database->closeConnection();
        return $result;
    }

    public function isAdmin($userId)
    {
        $dbConnection = $this->database->getConnection();
        $result = $dbConnection->query("SELECT * FROM users WHERE id = $userId ");
        $user = $result->fetch_assoc();

        $this->database->closeConnection();
        return $user;
    }
}