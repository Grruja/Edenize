<?php


namespace App\Validations;


use App\Repositories\ProductRepo;
use App\Support\Session;

class OrderValidation
{
    private array $validationErrors;
    private const VALIDATION_RULES = __DIR__ .'/../../config/validation_rules/shippingDetails.php';

    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }

    public function validateOrder(array $formData): bool
    {
        if (!$this->validateForm($formData)) return false;

        Session::start();
        $items = $_SESSION['cart']['items'];

        $ids = array_column($items, 'product_id');
        $productRepo = new ProductRepo();
        $products = $productRepo->getProductsByIdsNoStmt($ids);

        foreach ($products as $i => $product) {
            $this->validateQuantity($product, $items[$i]['quantity']);
        }
        return !isset($this->validationErrors['quantity']);
    }

    private function validateQuantity(array $product, int $quantity): void
    {
        if ($product['quantity'] == 0) {
            $this->validationErrors['quantity']['message'][] = $product['name'].' is sold out, no more remaining.';
            $this->validationErrors['quantity']['id'][] = $product['id'];

        } else if ($product['quantity'] < $quantity) {
            $this->validationErrors['quantity']['message'][] = $product['name'].' has insufficient stock. Available quantity: ' . $product['quantity'];
            $this->validationErrors['quantity']['id'][] = $product['id'];
        }
    }

    private function validateForm(array $formData): bool
    {
        $validationRules = require self::VALIDATION_RULES;

        foreach ($validationRules as $fieldName => $fieldInfo) {
            $this->validateField($formData, $fieldName, $fieldInfo);
        }
        return !isset($this->validationErrors['form']);
    }

    private function validateField(array $formData, string $fieldName, array $fieldInfo): void
    {
        if (empty($formData[$fieldName]) && $fieldInfo['required']) {
            $this->validationErrors['form'][$fieldName] = $fieldInfo['label'].' is required';
            return;
        }

        $inputValue = trim($formData[$fieldName]);

        if (isset($fieldInfo['min_length']) && strlen($inputValue) < $fieldInfo['min_length']) {
            $this->validationErrors['form'][$fieldName] = $fieldInfo['label'].' needs to have minimum '.$fieldInfo['min_length'].' characters';

        } else if (isset($fieldInfo['max_length']) && strlen($inputValue) > $fieldInfo['max_length']) {
            $this->validationErrors['form'][$fieldName] = $fieldInfo['label'].' needs to have maximum '.$fieldInfo['max_length'].' characters';
        }
    }
}