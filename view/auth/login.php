<?php
include '../components/head.php';
use App\Models\Auth;

if (Auth::check()) {
    header('Location: '.BASE_URL.'view/404.php');
    exit();
}
?>

<body>
    <?php include '../components/navigation.php'; ?>
    <main class="d-flex align-items-center">
        <div class="container shadow p-5 rounded-2 col-xxl-4 col-xl-5 col-lg-6 col-md-8">
            <h1 class="text-center mb-5">Login</h1>
            <form method="POST" action="<?= BASE_URL.'/inc/auth/loginInc.php' ?>">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" required class="form-control" id="username"
                           value="<?= $_POST['username'] ?? null ?>">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" required class="form-control" id="password">
                </div>

                <div>Don't have an account? <a href="register.php">Register</a></div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success">Login</button>
                </div>
            </form>
        </div>
    </main>
    <?php include '../components/footer.php'; ?>
</body>