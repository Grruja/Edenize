<?php
include 'components/head.php';

use App\Models\Auth;
use App\Models\Cart;
use App\Models\Product;


$product = new Product();
$permalink = $product->permalink($_GET['product_id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!Auth::check()) {
        header('Location: '.BASE_URL.'view/auth/login.php');
        exit();
    }

    $cart = new Cart();
    $cart->add($permalink['id'], $_POST['quantity'] ?? null);
    $error = $cart->getValidationError();
}
?>

<body>
    <?php include 'components/navigation.php'; ?>
    <main>
        <div class="container">
            <h1><?= $permalink['name'] ?></h1>
            <p><?= $permalink['description'] ?></p>
            <p>Left in stock: <?= $permalink['quantity'] ?></p>
            <p class="fs-2 my-4">$<?= $permalink['price'] ?></p>

            <form method="POST" action="">
                <div class="d-flex align-items-center gap-3">
                    <label for="quantity" class="form-label fw-bold">Quantity:</label>
                    <div class="col-md-1 col-sm-2 custom-col-xs-quantity">
                        <input type="number" name="quantity" value="1" required class="form-control" id="quantity">
                    </div>
                </div>
                <?php if (isset($error)) { ?>
                    <p class="text-danger"><?= $error ?></p>
                <?php } ?>
                <button class="btn btn-success mt-3">Add to Cart</button>
            </form>
        </div>
    </main>
    <?php include 'components/footer.php'; ?>

    <script>
        window.history.replaceState({}, document.title, window.location.href);
    </script>
</body>