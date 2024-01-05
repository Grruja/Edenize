<?php


namespace App\models;


use Database\Database;

require_once __DIR__.'/../../config/baseUrl.php';

class Product
{
    protected $database;
    
    public function __construct()
    {
        $this->database = new Database();
    }

    public function fetchFour()
    {
        $dbConnection = $this->database->getConnection();
        $result = $dbConnection->query("SELECT * FROM products ORDER BY created_at LIMIT 4");
        $this->database->closeConnection();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function permalink($productId)
    {
        if (!isset($productId)) {
            header('Location: '.BASE_URL.'view/404.php');
            exit();
        }

        $dbConnection = $this->database->getConnection();

        $stmt = $dbConnection->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        $this->database->closeConnection();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        header('Location: '.BASE_URL.'view/404.php');
        exit();
    }
}