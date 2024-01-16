<?php


namespace App\Models;


require_once __DIR__.'/../../config/baseUrl.php';

use App\Support\Session;

class Cart extends Product
{
    public function add($productId, $quantity)
    {
        if (!isset($productId) || empty($productId)) {
            header('Location: '.BASE_URL.'view/404.php');
            exit();
        }

        $dbProduct = $this->getProductById($productId);
        $quantityValidation = $this->validateQuantity($dbProduct['quantity'], $quantity);

        if ($quantityValidation) {
            Session::start();
            $cartUpdated = $this->updateCart($dbProduct['id'], $quantity);

            if (!$cartUpdated) {
                $_SESSION['cart']['items'][] = [
                    'product_id' => $dbProduct['id'],
                    'quantity' => $quantity,
                ];
            }
            $_SESSION['alert_message']['success'] = 'Product added to cart.';
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

    protected function validateQuantity($quantityLeft, $quantity)
    {
        Session::start();
        if (empty($quantity) || !is_numeric($quantity)) {
            $_SESSION['alert_message']['danger'] = 'Quantity is required';
            return false;

        } else if ($quantity <= 0) {
            $_SESSION['alert_message']['danger'] = 'Quantity must be greater than zero.';
            return false;

        } else if ($quantityLeft < $quantity) {
            $_SESSION['alert_message']['danger'] = 'Insufficient stock. Available quantity: ' . $quantityLeft;
            return false;
        }
        return true;
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
