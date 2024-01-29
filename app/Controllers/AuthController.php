<?php


namespace App\Controllers;


use App\Models\Auth;
use App\Support\Session;
use App\Validations\AuthValidation;

class AuthController extends Controller
{
    private Auth $authModel;

    public function __construct()
    {
        $this->authModel = new Auth();
        Session::start();
    }

    public function handleRegistration(array $params = []): void
    {
        $validation = new AuthValidation();
        $isValid = $validation->registerValidation($params);

        if (!$isValid) {
            $_SESSION['errors'] = $validation->getValidationErrors();
            $this->redirect('/register');
        }

        $this->authModel->register($_POST);
        $_SESSION['alert_message']['success'] = 'Your account is successfully created!';
        $this->redirect('/');
    }

    public function handleLogin(array $params = []): void
    {
        if (!isset($params['username']) || !isset($params['password'])) {
            $this->redirect('/login');
        }

        $login = $this->authModel->login($params['username'], $params['password']);

        if (!$login) {
            $_SESSION['alert_message']['danger'] = 'Invalid username or password.';
            $this->redirect('/login');
        }

        $_SESSION['alert_message']['success'] = 'Welcome back!';
        $this->redirect('/');
    }

    public function handleLogout(): void
    {
        if (!Session::isUserLogged()) $this->redirectTo404();

        Session::userLogout();
        $this->redirect('/login');
    }
}