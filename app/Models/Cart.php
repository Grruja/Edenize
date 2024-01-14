<?php


namespace App\Models;


require_once __DIR__.'/../../config/baseUrl.php';

use App\Support\Session;

class Cart extends Product
{
    private $validationError;

    public function add($productId, $quantity)
    {
        if (!isset($productId) || empty($productId)) {
            header('Location: '.BASE_URL.'view/404.php');
            exit();
        }

        $dbProduct = $this->getProductById($productId);
        $this->validateQuantity($dbProduct['quantity'], $quantity);

        if ($this->validationError == null) {
            Session::start();
            $_SESSION['cart'][] = [
                'product_id' => $dbProduct['id'],
                'quantity' => $quantity,
            ];
        }
    }

    public function get()
    {
        $cart = [];
        $total = 0;
        $dbConnection = $this->database->getConnection();

        foreach ($_SESSION['cart'] as $item) {
            $result = $dbConnection->query("SELECT * FROM products WHERE id = ".$item['product_id']);
            $product = $result->fetch_assoc();

            if ($product) {
                $cart[] = [
                    'name' => $product['name'],
                    'product_price' => $product['price'],
                    'quantity' => $item['quantity'],
                    'price' => $product['price'] * $item['quantity'],
                ];
                $total += $product['price'] * $item['quantity'];
            }
        }
        $this->database->closeConnection();

        return [
            'cart' => $cart,
            'total' => $total,
        ];
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
