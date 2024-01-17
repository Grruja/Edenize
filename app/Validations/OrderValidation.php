<?php


namespace App\Validations;


class OrderValidation
{
    private const VALIDATION_RULES = __DIR__ .'/../../config/validation_rules/shippingDetails.php';

    public function validateQuantity($product, $quantity)
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

    public function validateForm($formData)
    {
        $errors = [];
        $validationRules = require self::VALIDATION_RULES;

        foreach ($validationRules as $fieldName => $fieldInfo) {
            $this->validateField($formData, $fieldName, $fieldInfo,$errors);
        }
        return $errors;
    }

    private function validateField($formData, $fieldName, $fieldInfo, &$errors)
    {
        if (empty($formData[$fieldName]) && $fieldInfo['required']) {
            $errors[$fieldName] = $fieldInfo['label'].' is required';
            return;
        }

        $inputValue = trim($formData[$fieldName]);

        if (isset($fieldInfo['min_length']) && strlen($inputValue) < $fieldInfo['min_length']) {
            $errors[$fieldName] = $fieldInfo['label'].' needs to have minimum '.$fieldInfo['min_length'].' characters';

        } else if (isset($fieldInfo['max_length']) && strlen($inputValue) > $fieldInfo['max_length']) {
            $errors[$fieldName] = $fieldInfo['label'].' needs to have maximum '.$fieldInfo['max_length'].' characters';
        }
    }
}