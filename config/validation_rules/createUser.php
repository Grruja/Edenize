<?php

return [
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