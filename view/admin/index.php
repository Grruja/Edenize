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
        <h1 class="text-center mb-5">Admin</h1>

    </main>
    <?php include '../components/footer.php'; ?>
</body>