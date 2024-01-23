<?php


namespace App\Controllers;


use App\Models\Cart;
use App\Support\Session;
use App\Validations\CartValidation;

class CartController extends Controller
{
    private Cart $cartModel;

    public function __construct()
    {
        $this->cartModel = new Cart();
    }

    public function addProduct(): void
    {
        $validation = new CartValidation();
        if (!$validation->validateAddToCart($_POST)) {
            $this->redirect('view/product.php?product_id='.$_POST['product_id']);
        }

        $this->cartModel->addProduct($_POST['product_id'], $_POST['quantity']);

        Session::start();
        $_SESSION['alert_message']['success'] = 'Product added to cart.';
    }
}