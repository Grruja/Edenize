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

    public function create(): void
    {
        // validation here
        $imageName = basename($_FILES['image']['name']);
        $this->productModel->saveImage($imageName);
        $imagePath = $this->productModel->imagePathForDb($imageName);

        $this->productModel->create($_POST, $imagePath);

        Session::start();
        $_SESSION['alert_message']['success'] = 'Product created';
    }

    public function displayNewest(): array
    {
        return $this->productModel->getNewest();
    }

    public function permalink(): ?array
    {
        !isset($_GET['product_id']) ? $this->redirectTo404() : null;
        !is_numeric($_GET['product_id']) ? $this->redirectTo404() : null;

        $product = $this->productModel->getSingleProduct($_GET['product_id']);

        !isset($product) ? $this->redirectTo404() : null;
        return $product;
    }

    public function searchByName(): ?array
    {
        if (!isset($_GET['search_value'])) return $this->productModel->getAll();

        return $this->productModel->searchByName($_GET['search_value']);
    }
}