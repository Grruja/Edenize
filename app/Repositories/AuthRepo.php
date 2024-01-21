<?php


namespace App\Repositories;


class AuthRepo extends Repository
{
    public function insertUser(array $formData): \mysqli_stmt|bool
    {
        $password = password_hash($formData['password'], PASSWORD_BCRYPT);

        $dbConnection = $this->database->getConnection();

        $stmt = $dbConnection->prepare("INSERT INTO users (full_name, username, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $formData['full_name'], $formData['username'], $formData['email'], $password);
        $stmt->execute();
        $this->database->closeConnection();

        return $stmt;
    }

    public function recordExists(string $fieldName, string $inputValue): bool
    {
        $dbConnection = $this->database->getConnection();

        $stmt = $dbConnection->prepare("SELECT * FROM users WHERE $fieldName = ?");
        $stmt->bind_param('s', $inputValue);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 0) return false;
        return true;
    }

    public function userExists(string $username): bool
    {
        $dbConnection = $this->database->getConnection();

        $stmt = $dbConnection->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) return false;
        return true;
    }

    public function getUser(string $username): array
    {
        $dbConnection = $this->database->getConnection();

        $stmt = $dbConnection->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
}