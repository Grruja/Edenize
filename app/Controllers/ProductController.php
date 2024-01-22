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
        $this->productModel->create($_POST, $_FILES['image']);

        Session::start();
        $_SESSION['alert_message']['success'] = 'Product created';
    }
}