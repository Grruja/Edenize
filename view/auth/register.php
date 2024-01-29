<?php
include __DIR__ . '/../components/head.php';
use App\Controllers\AuthController;
use App\Support\Session;

if (Session::isUserLogged()) {
    header('Location: '.BASE_URL.'view/404.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $authController = new AuthController();
    $authController->handleRegistration();
}

$errors = $_SESSION['errors'] ?? null;
unset($_SESSION['errors']);
?>

<body>
    <?php include __DIR__ . '/../components/navigation.php'; ?>
    <main class="d-flex align-items-center mt-5">
        <div class="container border bg-light p-5 rounded-2 col-xxl-4 col-xl-5 col-lg-6 col-md-8">
            <h1 class="text-center mb-5">Register</h1>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="fullName" class="form-label">Full Name</label>
                    <input type="text" name="full_name" required class="form-control" id="fullName">
                    <?php if (isset($errors['full_name'])) : ?>
                        <p class="text-danger"><?= $errors['full_name'] ?></p>
                    <?php endif ?>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" required class="form-control" id="username">
                    <?php if (isset($errors['username'])) : ?>
                        <p class="text-danger"><?= $errors['username'] ?></p>
                    <?php endif ?>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" required class="form-control" id="email">
                    <?php if (isset($errors['email'])) : ?>
                        <p class="text-danger"><?= $errors['email'] ?></p>
                    <?php endif ?>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" required class="form-control" id="password">
                    <?php if (isset($errors['password'])) : ?>
                        <p class="text-danger"><?= $errors['password'] ?></p>
                    <?php endif ?>
                </div>
                <div class="mb-3">
                    <label for="passwordConfirm" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirm" required class="form-control" id="passwordConfirm">
                    <?php if (isset($errors['password_confirm'])) : ?>
                        <p class="text-danger"><?= $errors['password_confirm'] ?></p>
                    <?php endif ?>
                </div>

                <div>Already have an account? <a href="<?= BASE_URL ?>/login">Login</a></div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success">Register</button>
                </div>
            </form>
        </div>
    </main>
    <?php include __DIR__ . '/../components/footer.php'; ?>
</body>