<?php


namespace App\Models;


require_once __DIR__.'/../../config/baseUrl.php';

use App\Support\Session;
use App\Validations\OrderValidation;
use Database\Database;

class Order
{
    private $quantityErrors;
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function make($formData)
    {
        $validation = new OrderValidation();
        //validate form

        Session::start();
        foreach ($_SESSION['cart']['items'] as $item) {
            $result = $this->database->getConnection()->query("SELECT * FROM products WHERE id = ".$item['product_id']);
            $product = $result->fetch_assoc();

            $error = $validation->checkQuantity($product, $item['quantity']);
            $error ? $this->quantityErrors[] = $error : null;
        }

        if (!isset($this->quantityErrors)) {
            $order = $this->insertOrder($formData);
            $order->execute();

            if ($order) {
                $this->insertItems($order->insert_id);
                $_SESSION['alert_message'] = 'Order is successfully placed!';
            }
        }

        $this->database->closeConnection();
    }

    public function getQuantityErrors()
    {
        return $this->quantityErrors;
    }

    private function insertOrder($formData)
    {
        $stmt = $this->database->getConnection()->prepare("INSERT INTO orders (user_id, price, country, address, city, state, zip) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param('idsssss', $_SESSION['user_id'], $_SESSION['cart']['total'], $formData['country'], $formData['address'], $formData['city'], $formData['state'], $formData['zip']);
        return $stmt;
    }

    private function insertItems($orderId)
    {
        foreach ($_SESSION['cart']['items'] as $item) {
            $this->database->getConnection()->query("INSERT INTO order_items (order_id, product_id, quantity) VALUES ($orderId, '{$item['product_id']}', '{$item['quantity']}')");
            $this->database->getConnection()->query("UPDATE products SET quantity = quantity - {$item['quantity']} WHERE id = {$item['product_id']}");
        }
        unset($_SESSION['cart']);
    }
}