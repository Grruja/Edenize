<?php
include '../components/head.php';

use App\Models\Auth;

$auth = new Auth();
if (!$auth->adminCheck()) {
    header('Location: '.BASE_URL.'view/index.php');
    exit();
}
?>

<body>
    <?php include '../components/navigation.php'; ?>
    <main class="container">
        <h1>Admin</h1>
        <div class="container shadow p-5 rounded-2 col-xxl-4 col-xl-5 col-lg-6 col-md-8">
            <form method="POST" action="">
                <h2 class="text-center mb-5">Add Product</h2>
                <div class="mb-3">
                    <label for="fullName" class="form-label">Full Name</label>
                    <input type="text" name="full_name" required class="form-control" id="fullName">
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" required class="form-control" id="username">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" required class="form-control" id="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" required class="form-control" id="password">
                </div>
                <div class="mb-3">
                    <label for="passwordConfirm" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirm" required class="form-control" id="passwordConfirm">
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success">Add</button>
                </div>
            </form>
        </div>
    </main>
    <?php include '../components/footer.php'; ?>
</body>