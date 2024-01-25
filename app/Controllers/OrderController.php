<?php


namespace App\Controllers;


use App\Models\Order;
use App\Support\Session;
use App\Validations\OrderValidation;

class OrderController extends Controller
{
    private Order $orderModel;

    public function __construct()
    {
        $this->orderModel = new Order();
    }

    public function place(): void
    {
        $validation = new OrderValidation();

        if (!$validation->validateOrder($_POST)) {
            Session::start();
            $_SESSION['errors'] = $validation->getValidationErrors();
            $this->redirect('view/checkout.php');
        }

        $this->orderModel->create($_POST);

        Session::start();
        $_SESSION['alert_message']['success'] = 'Order is successfully placed!';
        $this->redirect('view/welcome.php');
    }
}