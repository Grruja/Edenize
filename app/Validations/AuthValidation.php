<?php


namespace App\Validations;


use App\Repositories\AuthRepo;

class AuthValidation
{
    private array $validationErrors;
    private const VALIDATION_RULES = __DIR__ . '/../../config/validation_rules/createUser.php';

    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }

    public function registerValidation(array $formData): bool
    {
        $validationRules = require self::VALIDATION_RULES;

        foreach ($validationRules as $fieldName => $fieldInfo) {
            $this->validateField($formData, $fieldName, $fieldInfo);
        }

        $this->validateEmail($formData['email']);
        $this->validatePassword($formData['password'], $formData['password_confirm']);

        if (isset($this->validationErrors)) return false;
        return true;
    }

    private function validateField(array $formData, string $fieldName, array $fieldInfo): void
    {
        if (empty($formData[$fieldName]) && $fieldInfo['required']) {
            $this->validationErrors[$fieldName] = $fieldInfo['label'].' is required';
            return;
        }

        $inputValue = trim($formData[$fieldName]);

        if (isset($fieldInfo['min_length']) && strlen($inputValue) < $fieldInfo['min_length']) {
            $this->validationErrors[$fieldName] = $fieldInfo['label'].' needs to have minimum '.$fieldInfo['min_length'].' characters';

        } else if (isset($fieldInfo['max_length']) && strlen($inputValue) > $fieldInfo['max_length']) {
            $this->validationErrors[$fieldName] = $fieldInfo['label'].' needs to have maximum '.$fieldInfo['max_length'].' characters';

        } else if ($fieldInfo['unique']) {
            $authRepo = new AuthRepo();
            $recordExists = $authRepo->recordExists($fieldName, $inputValue);

            if ($recordExists) {
                $this->validationErrors[$fieldName] = 'There is already an account with this '. strtolower($fieldInfo['label']);
            }
        }
    }

    private function validateEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->validationErrors['email'] = 'Please enter a valid email';
        }
    }

    private function validatePassword(string $password, string $passwordConfirm): void
    {
        if ($passwordConfirm !== $password) {
            $this->validationErrors['password_confirm'] = 'Password does not match';
        }
    }

}