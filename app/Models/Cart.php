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
        $this->updateCart($productId, $quantity);

        $_SESSION['cart']['items'][] = [
            'product_id' => $productId,
            'quantity' => $quantity,
        ];
    }

    public function getAllWithTotal(): array
    {
        $items = $_SESSION['cart']['items'];
        $cart = [];
        $total = 0;

        $ids = array_column($items, 'product_id');
        $products = $this->productRepo->getProductsByIdsNoStmt($ids);

        foreach ($products as $i => $product) {
            $cart[] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'product_price' => $product['price'],
                'quantity' => $items[$i]['quantity'],
                'image' => $product['image'],
                'price' => $product['price'] * $items[$i]['quantity'],
            ];
            $total += $product['price'] * $items[$i]['quantity'];
        }

        $_SESSION['cart']['total'] = $total;
        return array_reverse($cart);
    }

    public function remove(int $productId): void
    {
        foreach ($_SESSION['cart']['items'] as $index => $item) {
            if ($item['product_id'] == $productId) {
                unset($_SESSION['cart']['items'][$index]);
            }
        }
        $_SESSION['cart']['items'] = array_values($_SESSION['cart']['items']);

        if (count($_SESSION['cart']['items']) < 1) {
            unset($_SESSION['cart']);
        }
    }

    private function updateCart(int $productId, int $quantity): void
    {
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart']['items'] as &$item) {
                if ($item['product_id'] == $productId) {
                    $item['quantity'] += $quantity;
                }
            }
        }
    }
}
