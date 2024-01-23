<?php


namespace App\Repositories;


class OrderRepo extends Repository
{
    public function insertOrderReturnId(array $formData): ?int
    {
        $stmt = $this->dbConnection->prepare("INSERT INTO orders (user_id, price, country, address, city, state, zip) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param('idsssss', $_SESSION['user_id'], $_SESSION['cart']['total'], $formData['country'], $formData['address'], $formData['city'], $formData['state'], $formData['zip']);
        $stmt->execute();

        return $stmt->insert_id;
    }

    public function insertItem(int $orderId, array $item): void
    {
        $this->dbConnection->query("INSERT INTO order_items (order_id, product_id, quantity) VALUES ($orderId, '{$item['product_id']}', '{$item['quantity']}')");
    }
}