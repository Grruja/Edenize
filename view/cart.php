<?php
include 'components/head.php';

use App\Models\Auth;
use App\Models\Cart;
use App\Support\Session;

if (!Auth::check()) {
    header('Location: '.BASE_URL.'view/auth/login.php');
    exit();
}

// Add to cart request from index.php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart = new Cart();
    $cart->add($_POST['product_id'], $_POST['quantity'] ?? null);
}

Session::start();
if (isset($_SESSION['cart'])) {
    $cart = new Cart();
    $items = $cart->get();
}
?>

<body>
    <?php include 'components/navigation.php'; ?>
    <main class="container">
        <div class="d-flex gap-5">
            <div class="w-100">
                <h2 class="fw-bold mb-4">Cart</h2>
                <?php if (isset($_SESSION['cart'])) { ?>
                    <?php foreach ($items['cart'] as $item) { ?>
                        <a href="<?= BASE_URL ?>view/product.php?product_id=<?= $item['id'] ?>" class="text-decoration-none text-dark w-100">
                            <div class="bg-light shadow rounded-2 mb-3 p-3">
                                <p class="fs-5"><?= $item['name'] ?></p>
                                <p class="fs-5">$<?= $item['price'] ?></p>
                                <p class="text-secondary mt-2">Quantity: <?= $item['quantity'] ?></p>
                            </div>
                        </a>
                    <?php } ?>
                <?php } else { ?>
                    <p class="fs-5">There are no items in your cart.</p>
                <?php } ?>
            </div>

            <div class="w-100">
                <h2 class="fw-bold mb-4">Summary</h2>
                <div class="border-bottom fw-bold">
                    <div class="d-flex justify-content-between">
                        <p>Subtotal</p>
                        <p><?= isset($items['total']) ? '$' . $items['total'] : '--' ?></p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Estimated Shipping & Handling</p>
                        <p>--</p>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <p>Estimated Tax</p>
                        <p>--</p>
                    </div>
                </div>

                <div class="border-bottom fw-bold">
                    <div class="d-flex justify-content-between my-4">
                        <p>Total</p>
                        <p><?= isset($items['total']) ? '$' . $items['total'] : '--' ?></p>
                    </div>
                </div>

                <button class="btn btn-success w-100 mt-4 py-2">Checkout</button>
                <a href="<?= BASE_URL ?>view/index.php" class="btn btn-outline-success w-100 mt-2 py-2">Shop More</a>
            </div>
        </div>
    </main>
    <?php include 'components/footer.php'; ?>
</body>