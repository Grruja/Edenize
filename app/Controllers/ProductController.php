<?php


namespace App\Controllers;


use App\Models\Product;
use App\Repositories\ProductRepo;
use App\Support\Session;

class ProductController extends Controller
{
    private ProductRepo $productRepo;

    public function __construct()
    {
        $this->productRepo = new ProductRepo();
    }

    public function permalink(array $params = []): void
    {
        if (!isset($params['product_id'])) $this->redirectTo404();
        if (!is_numeric($params['product_id'])) $this->redirectTo404();

        $product = $this->productRepo->getProductById($params['product_id']);
        if (!isset($product)) $this->redirectTo404();

        $products = $this->productRepo->getNewest();

        require_once __DIR__ . '/../../view/product.php';
    }

    public function create(array $params = []): void
    {
        // validation here
        $productModel = new Product();

        $imageName = basename($_FILES['image']['name']);
        $productModel->saveImage($imageName);
        $imagePath = '/product_images/'.$imageName;

        $this->productRepo->insertProduct($params, $imagePath);

        Session::start();
        $_SESSION['alert_message']['success'] = 'Product created';
        $this->redirect('/admin');
    }

    public function searchByName(): ?array
    {
        if (!isset($_GET['search_value'])) return $this->productRepo->getAll();

        return $this->productRepo->searchByName($_GET['search_value']);
    }
}