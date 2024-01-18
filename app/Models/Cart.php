<?php


namespace App\Models;


require_once __DIR__.'/../../config/baseUrl.php';

use App\Repositories\ProductRepo;
use App\Support\Session;
use Database\Database;

class Cart
{
    private $productRepo;

    public function __construct()
    {
        $this->productRepo = new ProductRepo();
    }

    public function add($productId, $quantity)
    {
        if (!isset($productId) || empty($productId)) {
            header('Location: '.BASE_URL.'view/404.php');
            exit();
        }

        $dbProduct = $this->productRepo->getProductById($productId, 1);
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

        Session::start();
        foreach ($_SESSION['cart']['items'] as $item) {
            $product = $this->productRepo->getProductById($item['product_id'], 0);

            if ($product) {
                $cart[] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'product_price' => $product['price'],
                    'quantity' => $item['quantity'],
                    'image' => $product['image'],
                    'price' => $product['price'] * $item['quantity'],
                ];
                $total += $product['price'] * $item['quantity'];
            }
        }
        $db = new Database();
        $db->closeConnection();

        $_SESSION['cart']['total'] = $total;
        return $cart;
    }

    public function remove($productId)
    {
        if (!isset($productId) || empty($productId)) {
            header('Location: '.BASE_URL.'view/cart.php');
            exit();
        }

        Session::start();
        foreach ($_SESSION['cart']['items'] as $index => $item) {
            if ($item['product_id'] == $productId) {
                unset($_SESSION['cart']['items'][$index]);
            }
        }

        if (count($_SESSION['cart']['items']) < 1) {
            unset($_SESSION['cart']);
        }
        header('Location: '.BASE_URL.'view/cart.php');
        exit();
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
