<?php


namespace App\Models;


use App\Repositories\OrderRepo;
use App\Repositories\ProductRepo;

class Order
{
    private OrderRepo $orderRepo;

    public function __construct()
    {
        $this->orderRepo = new OrderRepo();
    }

    public function create(array $formData): void
    {
        $orderId = $this->orderRepo->insertOrderReturnId($formData);
        $this->insertItems($orderId);
    }

    private function insertItems(int $orderId): void
    {
        $productRepo = new ProductRepo();

        foreach ($_SESSION['cart']['items'] as $item) {
            $this->orderRepo->insertItem($orderId, $item);
            $productRepo->decreaseQuantity($item);
        }
        unset($_SESSION['cart']);
    }
}