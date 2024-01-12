<?php
include 'components/head.php';

use App\Models\Auth;
use App\Models\Cart;

if (!Auth::check()) {
    header('Location: '.BASE_URL.'view/auth/login.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart = new Cart();
    $cart->add($_POST['product_id'], $_POST['quantity'] ?? null);
}
?>

<body>
    <?php include 'components/navigation.php'; ?>
    <main>
        <h1>my cart</h1>
    </main>
    <?php include 'components/footer.php'; ?>
</body>