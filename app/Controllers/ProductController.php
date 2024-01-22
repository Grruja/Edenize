<?php


namespace App\Controllers;


use App\Models\Product;
use App\Support\Session;

class ProductController extends Controller
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function createProduct(): void
    {
        // validation here
        $imageName = basename($_FILES['image']['name']);
        $this->productModel->saveImage($imageName);
        $imagePath = $this->productModel->imagePathForDb($imageName);

        $this->productModel->create($_POST, $imagePath);

        Session::start();
        $_SESSION['alert_message']['success'] = 'Product created';
    }
}