<?php
    require_once '../vendor/autoload.php';
    use App\models\User;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user = new User();
        $user->create($_POST);
        $errors = $user->getValidationErrors();
        $oldData = $_POST;
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Welcome</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="../public/css/style.css">
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container">
                    <a class="navbar-brand" href="index.php">Edenize</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="register.php">Register</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <main>
            <div class="container">
                <h1>Register</h1>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" name="full_name" required class="form-control" id="fullName">
                        <?php if (isset($errors['full_name'])) { ?>
                            <p class="text-danger"><?= $errors['full_name'] ?></p>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" required class="form-control" id="username">
                        <?php if (isset($errors['username'])) { ?>
                            <p class="text-danger"><?= $errors['username'] ?></p>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" name="email" required class="form-control" id="email">
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

        <footer class="bg-success text-white py-5">
            <div class="container">
                <small>&copy <?= date('Y') ?> Edenize. All rights reserved</small>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    </body>
</html>