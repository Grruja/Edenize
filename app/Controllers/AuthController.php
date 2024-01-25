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
    }

    public function handleRegistration(): void
    {
        $validation = new AuthValidation();
        $isValid = $validation->registerValidation($_POST);

        if (!$isValid) {
            Session::start();
            $_SESSION['errors'] = $validation->getValidationErrors();
            $this->redirect('view/auth/register.php');
        }

        $this->authModel->register($_POST);
        $_SESSION['alert_message']['success'] = 'Your account is successfully created!';
        $this->redirect('view/welcome.php');
    }

    public function handleLogin(): void
    {
        if (!isset($_POST['username']) || !isset($_POST['password'])) {
            $this->redirect('view/auth/login.php');
        }

        $login = $this->authModel->login($_POST['username'], $_POST['password']);

        if (!$login) {
            $_SESSION['alert_message']['danger'] = 'Invalid username or password.';
            $this->redirect('view/auth/login.php');
        }

        $_SESSION['alert_message']['success'] = 'Welcome back!';
        $this->redirect('view/welcome.php');
    }

    public function handleLogout(): void
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') $this->redirectTo404();

        if (!Session::isUserLogged()) $this->redirectTo404();

        Session::userLogout();
        $this->redirect('view/auth/login.php');
    }
}