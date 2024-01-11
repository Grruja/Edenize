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
            new Session();
            $_SESSION['cart'][] = [
                'product_id' => $dbProduct['id'],
                'quantity' => $quantity,
            ];
        }
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
