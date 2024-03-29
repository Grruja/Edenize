<?php
include __DIR__ . '/../components/head.php';
use App\Support\Session;

if (Session::isUserLogged()) {
    http_response_code(404);
    require_once __DIR__ . '/../../view/404.php';
    exit();
}
?>

<body>
    <?php include __DIR__ . '/../components/navigation.php'; ?>
    <main class="d-flex align-items-center">
        <div class="container border p-5 rounded-2 bg-light col-xxl-4 col-xl-5 col-lg-6 col-md-8">
            <h1 class="text-center mb-5">Login</h1>
            <form method="POST" action="<?= BASE_URL ?>/login/send">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" required class="form-control" id="username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" required class="form-control" id="password">
                </div>

                <div>Don't have an account? <a href="<?= BASE_URL ?>/register">Register</a></div>

                <div class="alert alert-primary my-4">
                    <p class="fw-bold">Demo Account</p>
                    <p>Username: demo</p>
                    <p>Password: demo12345</p>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success">Login</button>
                </div>
            </form>
        </div>
    </main>
    <?php include __DIR__ . '/../components/footer.php'; ?>
</body>