<?php
include 'components/head.php';

use App\Models\Auth;
use App\Models\Product;
use App\Support\Session;


$product = new Product();
$permalink = $product->permalink($_GET['product_id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    new Session();
    if (!Auth::isLogged()) {
        header('Location: '.BASE_URL.'view/auth/login.php');
        exit();
    }

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
                <div class="d-flex align-items-center gap-3 mb-3">
                    <label for="quantity" class="form-label fw-bold">Quantity:</label>
                    <div class="col-md-1 col-sm-2 custom-col-xs-quantity">
                        <input type="number" name="quantity" value="1" required class="form-control" id="quantity">
                    </div>
                </div>
                <button class="btn btn-success">Add to Cart</button>
            </form>
        </div>
    </main>
    <?php include 'components/footer.php'; ?>
</body>