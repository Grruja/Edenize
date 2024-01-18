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

    public function userExists($username)
    {
        $dbConnection = $this->database->getConnection();

        $stmt = $dbConnection->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) return false;
        return true;
    }

    public function getUser($username)
    {
        $dbConnection = $this->database->getConnection();

        $stmt = $dbConnection->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
}