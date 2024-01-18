<?php


namespace App\Models;


require_once __DIR__.'/../../config/baseUrl.php';

use App\Repositories\ProductRepo;
use App\Support\Session;

class Product
{
    protected $productRepo;
    
    public function __construct()
    {
        $this->productRepo = new ProductRepo();
    }

    public function create($formData, $image)
    {
        //need validation
        $imagePath = $this->saveImage($image);
        $result = $this->productRepo->create($formData, $imagePath);

        Session::start();
        if ($result) {
            $_SESSION['alert_message']['success'] = 'Product created';

        } else {
            $_SESSION['alert_message']['danger'] = 'Product is not created';
        }
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