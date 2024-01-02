<?php
    /*require_once '../vendor/autoload.php';
    use App\models\User;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user = new User();
        $user->create($_POST);
        $errors = $user->getValidationErrors();
    }*/
?>

<?php include 'components/head.php'; ?>

<body>
    <?php include 'components/navigation.php'; ?>
    <main class="d-flex align-items-center">
        <div class="container shadow p-5 rounded-2 col-xl-5 col-lg-6 col-md-8">
            <h1 class="text-center mb-5">Login</h1>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" required class="form-control" id="username"
                           value="<?= $_POST['username'] ?? null ?>">
                    <?php if (isset($errors['username'])) { ?>
                        <p class="text-danger"><?= $errors['username'] ?></p>
                    <?php } ?>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" required class="form-control" id="password">
                    <?php if (isset($errors['password'])) { ?>
                        <p class="text-danger"><?= $errors['password'] ?></p>
                    <?php } ?>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Login</button>
                </div>
            </form>
        </div>
    </main>
    <?php include 'components/footer.php'; ?>
</body>