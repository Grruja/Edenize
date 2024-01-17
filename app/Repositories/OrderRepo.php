<?php


namespace App\Repositories;


class OrderRepo extends Repository
{
    public function insertOrder($formData)
    {
        $stmt = $this->database->getConnection()->prepare("INSERT INTO orders (user_id, price, country, address, city, state, zip) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param('idsssss', $_SESSION['user_id'], $_SESSION['cart']['total'], $formData['country'], $formData['address'], $formData['city'], $formData['state'], $formData['zip']);
        $execute = $stmt->execute();

        return [
            'execute' => $execute,
            'stmt' => $stmt,
        ];
    }

    public function insertItem($orderId, $item)
    {
        $this->database->getConnection()->query("INSERT INTO order_items (order_id, product_id, quantity) VALUES ($orderId, '{$item['product_id']}', '{$item['quantity']}')");
    }
}