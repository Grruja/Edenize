<?php


namespace App\classes\validations;


use App\classes\User;

class UserValidation extends User
{
    const VALIDATION_RULES = [
        'full_name' => [
            'label' => 'Name',
            'min_length' => 2,
            'max_length' => 255,
            'required' => true,
            'unique' => false,
        ],
        'username' => [
            'label' => 'Username',
            'min_length' => 2,
            'max_length' => 255,
            'required' => true,
            'unique' => true,
        ],
        'email' => [
            'label' => 'Email',
            'min_length' => 2,
            'max_length' => 255,
            'required' => true,
            'unique' => true,
        ],
        'password' => [
            'label' => 'Password',
            'min_length' => 7,
            'max_length' => 255,
            'required' => true,
            'unique' => false,
        ],
        'password_confirm' => [
            'label' => 'Confirm Password',
            'required' => true,
            'unique' => false,
        ],
    ];

    public function validateCreateUser($formData)
    {
        $errors = [];

        foreach (self::VALIDATION_RULES as $fieldName => $fieldInfo) {
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