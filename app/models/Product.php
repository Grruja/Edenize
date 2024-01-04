<?php


namespace App\models;


use Database\Database;

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
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

/**
 * PRODUCT
 *
 * id
 * name
 * price
 * quantity
 * description
 * image
 * created_at
*/