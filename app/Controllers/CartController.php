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
        Session::start();
    }

    public function addProduct(): void
    {
        $validation = new CartValidation();
        if (!$validation->validateAddToCart($_POST)) {
            $this->redirect('/product?product_id='.$_POST['product_id']);
        }

        $this->cartModel->addProduct($_POST['product_id'], $_POST['quantity']);
        $_SESSION['alert_message']['success'] = 'Product added to cart.';
    }

    public function displayAllWithTotal(): ?array
    {
        if (!isset($_SESSION['cart'])) return null;
        return $this->cartModel->getAllWithTotal();
    }

    public function removeFromCart(): void
    {
        if (!isset($_SESSION['cart']) ||
            !isset($_POST['product_id']) ||
            empty($_POST['product_id']))
        {
            $this->redirect('/cart');
        }

        $this->cartModel->remove($_POST['product_id']);
        $this->redirect('/cart');
    }
}