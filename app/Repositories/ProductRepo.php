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

    public function getAll()
    {
        $dbConnection = $this->database->getConnection();
        $result = $dbConnection->query("SELECT * FROM products");
        $this->database->closeConnection();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getFourNewest()
    {
        $dbConnection = $this->database->getConnection();
        $result = $dbConnection->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 4");
        $this->database->closeConnection();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function searchByName($searchValue)
    {
        $dbConnection = $this->database->getConnection();
        $stmt = $dbConnection->prepare("SELECT * FROM products WHERE name LIKE ?");

        $searchPattern = '%'. $searchValue. '%';

        $stmt->bind_param('s', $searchPattern);
        $stmt->execute();
        $result = $stmt->get_result();

        $this->database->closeConnection();

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }

    public function decreaseQuantity($product)
    {
        $this->database->getConnection()->query("UPDATE products SET quantity = quantity - {$product['quantity']} WHERE id = {$product['product_id']}");
    }
}