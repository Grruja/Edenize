<?php


namespace App\Validations;


use App\Repositories\ProductRepo;
use App\Support\Session;

class CartValidation
{
    public function validateAddToCart(array $formData): bool
    {
        if (!$this->validateFieldsAddToCart($formData)) return false;

        $productRepo = new ProductRepo();
        $product = $productRepo->getProductById($formData['product_id']);
        if (!isset($product)) return false;

        $isValidQuantity = $this->validateQuantity($product['quantity'], $formData['quantity']);
        if (!$isValidQuantity) return false;

        return true;
    }

    private function validateQuantity(int $quantityLeft, int $quantity): bool
    {
        Session::start();
        if ($quantity <= 0) {
            return false;

        } else if ($quantityLeft < $quantity) {
            $_SESSION['alert_message']['danger'] = 'Insufficient stock. Available quantity: ' . $quantityLeft;
            return false;
        }
        return true;
    }

    private function validateFieldsAddToCart(array $formData): bool
    {
        $requiredFields = ['product_id', 'quantity'];

        foreach ($requiredFields as $field) {
            if (!isset($formData[$field]) || empty($formData[$field]) || !is_numeric($formData[$field])) {
                return false;
            }
        }
        return true;
    }
}