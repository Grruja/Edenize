<?php


namespace App\Models;


use App\Repositories\ProductRepo;

class Product
{
    private ProductRepo $productRepo;
    
    public function __construct()
    {
        $this->productRepo = new ProductRepo();
    }

    public function create(array $formData, string $imagePath): void
    {
        $this->productRepo->insertProduct($formData, $imagePath);
    }

    public function getAll(): array
    {
        return $this->productRepo->getAll();
    }

    public function searchByName(string $searchValue): ?array
    {
        return $this->productRepo->searchByName($searchValue);
    }

    public function getNewest(): array
    {
        return $this->productRepo->getNewest();
    }

    public function getSingleProduct(int $productId): ?array
    {
        return $this->productRepo->getProductById($productId);
    }

    public function saveImage(string $imageName): void
    {
        $storagePath = '../../public/product_images/'.$imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $storagePath);
    }

    public function imagePathForDb(string $imageName): string
    {
        return 'public/product_images/'.$imageName;
    }
}