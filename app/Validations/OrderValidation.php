<?php


namespace App\Validations;


use App\Models\Order;

class OrderValidation extends Order
{
    protected function checkQuantity($product, $quantity)
    {
        $error = [];
        if ($product['quantity'] == 0) {
            $error['message'] = $product['name'].' is sold out, no more remaining.';
            $error['id'] = $product['id'];
            return $error;

        } else if ($product['quantity'] < $quantity) {
            $error['message'] = $product['name'].' has insufficient stock. Available quantity: ' . $product['quantity'];
            $error['id'] = $product['id'];
        }
        return $error;
    }
}