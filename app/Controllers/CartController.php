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

    public function addProduct(array $params = []): void
    {
        if (!Session::isUserLogged()) $this->redirect('/login');

        $validation = new CartValidation();
        if (!$validation->validateAddToCart($params)) {
            $this->redirect('/product?product_id='.$params['product_id']);
        }

        $this->cartModel->addProduct($params['product_id'], $params['quantity']);
        $_SESSION['alert_message']['success'] = 'Product added to cart.';
        $this->redirect('/product?product_id=' . $params['product_id']);
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