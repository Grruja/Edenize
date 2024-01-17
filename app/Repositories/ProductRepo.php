<?php


namespace App\Repositories;


class ProductRepo extends Repository
{
    public function getProductById($productId, $wayToFind)
    {
        $dbConnection = $this->database->getConnection();

        if ($wayToFind == 1) {
            $stmt = $dbConnection->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->bind_param('i', $productId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            }
            header('Location: '.BASE_URL.'view/404.php');
            exit();

        } else {
            $result = $dbConnection->query("SELECT * FROM products WHERE id = ".$productId);
            return $result->fetch_assoc();
        }
    }

    public function decreaseQuantity($item)
    {
        $this->database->getConnection()->query("UPDATE products SET quantity = quantity - {$item['quantity']} WHERE id = {$item['product_id']}");
    }
}