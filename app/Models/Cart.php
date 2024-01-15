<?php


namespace App\Models;


require_once __DIR__.'/../../config/baseUrl.php';

use App\Support\Session;

class Cart extends Product
{
    private $quantityErrors;

    public function add($productId, $quantity)
    {
        if (!isset($productId) || empty($productId)) {
            header('Location: '.BASE_URL.'view/404.php');
            exit();
        }

        $dbProduct = $this->getProductById($productId);
        $this->validateQuantity($dbProduct['id'], $dbProduct['quantity'], $quantity);

        if (!isset($this->quantityErrors[$dbProduct['id']])) {
            Session::start();
            $cartUpdated = $this->updateCart($dbProduct['id'], $quantity);

            if (!$cartUpdated) {
                $_SESSION['cart']['items'][] = [
                    'product_id' => $dbProduct['id'],
                    'quantity' => $quantity,
                ];
            }
            $_SESSION['alert_message'] = 'Product added to cart.';
        }
    }

    public function get()
    {
        $cart = [];
        $total = 0;
        $dbConnection = $this->database->getConnection();

        Session::start();
        foreach ($_SESSION['cart']['items'] as $item) {
            $result = $dbConnection->query("SELECT * FROM products WHERE id = ".$item['product_id']);
            $product = $result->fetch_assoc();

            if ($product) {
                $cart[] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'product_price' => $product['price'],
                    'quantity' => $item['quantity'],
                    'price' => $product['price'] * $item['quantity'],
                ];
                $total += $product['price'] * $item['quantity'];
            }
        }
        $this->database->closeConnection();

        $_SESSION['cart']['total'] = $total;
        return $cart;
    }

    public function getQuantityErrors()
    {
        return $this->quantityErrors;
    }

    protected function validateQuantity($productId, $quantityLeft, $quantity)
    {
        if (empty($quantity) || !is_numeric($quantity)) {
            $this->quantityErrors[$productId] = 'Quantity is required';
        } else if ($quantity <= 0) {
            $this->quantityErrors[$productId] = 'Quantity must be greater than zero.';
        } else if ($quantityLeft < $quantity) {
            $this->quantityErrors[$productId] = 'Insufficient stock. Available quantity: ' . $quantityLeft;
        }
    }

    private function updateCart($productId, $quantity)
    {
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart']['items'] as &$item) {
                if ($item['product_id'] == $productId) {
                    $item['quantity'] += $quantity;
                    return true;
                }
            }
        }
        return false;
    }
}
