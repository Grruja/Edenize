<?php


namespace App\Repositories;


class ProductRepo extends Repository
{
    public function insertProduct(array $formData, string $imagePath): void
    {
        $stmt = $this->dbConnection->prepare("INSERT INTO products (name, price, quantity, description, image) VALUES (?,?,?,?,?)");
        $stmt->bind_param('sdiss', $formData['name'], $formData['price'], $formData['quantity'], $formData['description'], $imagePath);
        $stmt->execute();
    }

    public function getProductById($productId, $wayToFind)
    {
        if ($wayToFind == 1) {
            $stmt = $this->dbConnection->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->bind_param('i', $productId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            }
            header('Location: '.BASE_URL.'view/404.php');
            exit();

        } else {
            $result = $this->dbConnection->query("SELECT * FROM products WHERE id = ".$productId);
            return $result->fetch_assoc();
        }
    }

    public function getAll()
    {
        $result = $this->dbConnection->query("SELECT * FROM products");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getFourNewest()
    {
        $result = $this->dbConnection->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 4");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function searchByName($searchValue)
    {
        $stmt = $this->dbConnection->prepare("SELECT * FROM products WHERE name LIKE ?");

        $searchPattern = '%'. $searchValue. '%';

        $stmt->bind_param('s', $searchPattern);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }

    public function decreaseQuantity($product)
    {
        $this->dbConnection->query("UPDATE products SET quantity = quantity - {$product['quantity']} WHERE id = {$product['product_id']}");
    }
}