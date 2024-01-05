<?php


namespace App\validations;


use App\models\Auth;

class AuthValidation extends Auth
{
    const VALIDATION_RULES = '../../config/validation_rules/createUser.php';

    public function validateCreateUser($formData)
    {
        $errors = [];

        $validationRules = require self::VALIDATION_RULES;

        foreach ($validationRules as $fieldName => $fieldInfo) {
            $this->validateField($formData, $fieldName, $fieldInfo,$errors);
        }
        $this->database->closeConnection();

        $this->validateEmail($formData['email'],$errors);
        $this->validatePassword($formData['password'], $formData['password_confirm'], $errors);

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

        } else if ($fieldInfo['unique']) {
            $database = $this->database->getConnection();

            $fieldColumn = $database->query("SELECT * FROM users WHERE $fieldName = '$inputValue'");

            if ($fieldColumn->num_rows > 0) {
                $errors[$fieldName] = 'There is already an account with this '. strtolower($fieldInfo['label']);
            }
        }
    }

    private function validateEmail($email, &$errors)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email';
        }
    }

    private function validatePassword($password, $passwordConfirm, &$errors)
    {
        if ($passwordConfirm !== $password) {
            $errors['password_confirm'] = 'Password does not match';
        }
    }

}