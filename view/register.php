<?php
    require_once '../vendor/autoload.php';
    use App\models\User;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user = new User();
        $user->create($_POST);
        $errors = $user->getValidationErrors();
    }
?>

<?php include 'components/head.php'; ?>

<body>
    <?php include 'components/navigation.php'; ?>
    <main>
        <div class="container">
            <h1>Register</h1>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="fullName" class="form-label">Full Name</label>
                    <input type="text" name="full_name" required class="form-control" id="fullName"
                           value="<?= $_POST['full_name'] ?? null ?>">
                    <?php if (isset($errors['full_name'])) { ?>
                        <p class="text-danger"><?= $errors['full_name'] ?></p>
                    <?php } ?>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" required class="form-control" id="username"
                           value="<?= $_POST['username'] ?? null ?>">
                    <?php if (isset($errors['username'])) { ?>
                        <p class="text-danger"><?= $errors['username'] ?></p>
                    <?php } ?>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" required class="form-control" id="email"
                           value="<?= $_POST['email'] ?? null ?>">
                    <?php if (isset($errors['email'])) { ?>
                        <p class="text-danger"><?= $errors['email'] ?></p>
                    <?php } ?>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" required class="form-control" id="password">
                    <?php if (isset($errors['password'])) { ?>
                        <p class="text-danger"><?= $errors['password'] ?></p>
                    <?php } ?>
                </div>
                <div class="mb-3">
                    <label for="passwordConfirm" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirm" required class="form-control" id="passwordConfirm">
                    <?php if (isset($errors['password_confirm'])) { ?>
                        <p class="text-danger"><?= $errors['password_confirm'] ?></p>
                    <?php } ?>
                </div>
                <button type="submit" class="btn btn-success">Register</button>
            </form>
        </div>
    </main>
    <?php include 'components/footer.php'; ?>
</body>