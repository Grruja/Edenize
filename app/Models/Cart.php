<?php


namespace App\Models;


require_once __DIR__.'/../../config/baseUrl.php';

use App\Support\Session;
use Database\Database;

class Cart
{
    protected $database;
    private $validationError;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function add($productId, $quantity)
    {
        $dbProduct = $this->getProductById($productId);
        $this->validateQuantity($dbProduct['quantity'], $quantity);

        if ($this->validationError == null) {
            new Session();
            $_SESSION['cart'][] = [
                'product_id' => $dbProduct['id'],
                'quantity' => $quantity,
            ];
        }
    }

    private function getProductById($productId)
    {
        $dbConnection = $this->database->getConnection();
        $stmt = $dbConnection->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param('i', $productId);
        $stmt->execute();

        $result = $stmt->get_result();
        $this->database->closeConnection();

        return $result->fetch_assoc();
    }

    private function validateQuantity($quantityLeft, $quantity)
    {
        if (empty($quantity) || !is_numeric($quantity)) {
            $this->validationError = 'Quantity is required';
        } else if ($quantity <= 0) {
            $this->validationError = 'Quantity must be greater than zero.';
        } else if ($quantityLeft < $quantity) {
            $this->validationError = 'Insufficient stock. Available quantity: ' . $quantityLeft;
        }
    }

    public function getValidationError()
    {
        return $this->validationError;
    }
}
