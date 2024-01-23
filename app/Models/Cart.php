<?php


namespace App\Models;


require_once __DIR__.'/../../config/baseUrl.php';

use App\Repositories\ProductRepo;
use App\Support\Session;

class Cart
{
    private ProductRepo $productRepo;

    public function __construct()
    {
        $this->productRepo = new ProductRepo();
        Session::start();
    }

    public function addProduct(int $productId, int $quantity): void
    {
        $cartUpdated = $this->updateCart($productId, $quantity);

        if (!$cartUpdated) {
            $_SESSION['cart']['items'][] = [
                'product_id' => $productId,
                'quantity' => $quantity,
            ];
        }
    }

    public function get()
    {
        $cart = [];
        $total = 0;

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

        $_SESSION['cart']['total'] = $total;
        return $cart;
    }

    public function remove($productId)
    {
        if (!isset($productId) || empty($productId)) {
            header('Location: '.BASE_URL.'view/cart.php');
            exit();
        }

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
