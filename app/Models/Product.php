<?php


namespace App\Models;


require_once __DIR__.'/../../config/baseUrl.php';

use App\Repositories\ProductRepo;
use App\Support\Session;

class Product
{
    protected ProductRepo $productRepo;
    
    public function __construct()
    {
        $this->productRepo = new ProductRepo();
    }

    public function create(array $formData, array $image): void
    {
        $imagePath = $this->saveImage($image);
        $this->productRepo->insertProduct($formData, $imagePath);
    }

    public function all()
    {
        return $this->productRepo->getAll();
    }

    public function search($searchValue)
    {
        if (!isset($searchValue) || empty($searchValue)) {
            header('Location:'. BASE_URL.'view/shop.php');
            exit();
        }

        return $this->productRepo->searchByName($searchValue);
    }

    public function getNewest()
    {
        return $this->productRepo->getFourNewest();
    }

    public function permalink($productId)
    {
        if (!isset($productId)) {
            header('Location: '.BASE_URL.'view/404.php');
            exit();
        }
        return $this->productRepo->getProductById($productId, 1);
    }

    private function saveImage($image)
    {
        //need validation
        $imageName = basename($image['name']);
        $imagePath = 'public/product_images/'.$imageName;

        $storagePath = '../../public/product_images/'.$imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $storagePath);

        return $imagePath;
    }
}