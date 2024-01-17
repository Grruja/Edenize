<?php


namespace App\Models;


require_once __DIR__.'/../../config/baseUrl.php';

use App\Repositories\ProductRepo;

class Product
{
    protected $productRepo;
    
    public function __construct()
    {
        $this->productRepo = new ProductRepo();
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
}