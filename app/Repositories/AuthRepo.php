<?php


namespace App\Repositories;


class AuthRepo extends Repository
{
    public function insertUserReturnId(array $formData): int
    {
        $password = password_hash($formData['password'], PASSWORD_BCRYPT);

        $stmt = $this->dbConnection->prepare("INSERT INTO users (full_name, username, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $formData['full_name'], $formData['username'], $formData['email'], $password);
        $stmt->execute();

        return $stmt->insert_id;
    }

    public function recordExists(string $fieldName, string $inputValue): bool
    {
        $stmt = $this->dbConnection->prepare("SELECT * FROM users WHERE $fieldName = ?");
        $stmt->bind_param('s', $inputValue);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 0) return false;
        return true;
    }

    public function userExists(string $username): bool
    {
        $stmt = $this->dbConnection->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) return false;
        return true;
    }

    public function getUser(string $username): array
    {
        $stmt = $this->dbConnection->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
}