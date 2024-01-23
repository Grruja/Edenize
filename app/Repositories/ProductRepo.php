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

    public function getProductById(int $productId): ?array
    {
        $stmt = $this->dbConnection->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0 ? $result->fetch_assoc() : null;
    }

    public function getProductsByIdsNoStmt(array $ids): array
    {
        $idsString = implode(',', $ids);

        $result = $this->dbConnection->query("SELECT * FROM products WHERE id IN ($idsString) ORDER BY FIELD(id, $idsString)");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAll(): array
    {
        $result = $this->dbConnection->query("SELECT * FROM products");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getNewest($limit = 4): array
    {
        $result = $this->dbConnection->query("SELECT * FROM products ORDER BY created_at DESC LIMIT $limit");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function searchByName(string $searchValue): ?array
    {
        $stmt = $this->dbConnection->prepare("SELECT * FROM products WHERE name LIKE ?");
        $searchPattern = '%'. $searchValue. '%';
        $stmt->bind_param('s', $searchPattern);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : null;
    }

    public function decreaseQuantity(array $product): void
    {
        $this->dbConnection->query("UPDATE products SET quantity = quantity - {$product['quantity']} WHERE id = {$product['product_id']}");
    }
}