<?php


namespace App\Models;


require_once __DIR__.'/../../config/baseUrl.php';

use App\Repositories\OrderRepo;
use App\Repositories\ProductRepo;
use App\Support\Session;
use App\Validations\OrderValidation;
use Database\Database;

class Order
{
    private $orderRepo;
    private $productRepo;
    private $quantityErrors;
    private $formErrors;

    public function __construct()
    {
        $this->orderRepo = new OrderRepo();
        $this->productRepo = new ProductRepo();
    }

    public function make($formData)
    {
        $validation = new OrderValidation();
        $formValidation = $validation->validateForm($formData);
        $formValidation ? $this->formErrors = $formValidation : null;

        if (!isset($this->formErrors)) {
            Session::start();
            foreach ($_SESSION['cart']['items'] as $item) {
                $product = $this->productRepo->getProductById($item['product_id'], 0);

                $quantityValidation = $validation->validateQuantity($product, $item['quantity']);
                $quantityValidation ? $this->quantityErrors[] = $quantityValidation : null;
            }

            if (!isset($this->quantityErrors)) {
                $order = $this->orderRepo->insertOrder($formData);

                if ($order['execute']) {
                    $this->insertItems($order['stmt']->insert_id);
                    $_SESSION['alert_message']['success'] = 'Order is successfully placed!';
                }
            }
            $db = new Database();
            $db->closeConnection();

            header('Location:'.BASE_URL.'view/cart.php');
            exit();
        }
    }

    public function getQuantityErrors()
    {
        return $this->quantityErrors;
    }

    public function getFormErrors()
    {
        return $this->formErrors;
    }

    private function insertItems($orderId)
    {
        foreach ($_SESSION['cart']['items'] as $item) {
            $this->orderRepo->insertItem($orderId, $item);
            $this->productRepo->decreaseQuantity($item);
        }
        unset($_SESSION['cart']);
    }
}