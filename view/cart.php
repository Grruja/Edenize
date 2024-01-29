<?php
include 'components/head.php';

use App\Controllers\CartController;
use App\Support\Session;

if (!Session::isUserLogged()) {
    header('Location: '.BASE_URL.'/login');
    exit();
}

$cartController = new CartController();
$items = $cartController->displayAllWithTotal();
?>

<body>
    <?php include 'components/navigation.php'; ?>
    <main class="container mt-5">
        <div class="d-flex flex-md-row flex-column gap-5">
            <div class="w-100">
                <h2 class="fw-bold mb-4">Cart</h2>
                <?php if (isset($_SESSION['cart'])) : ?>
                    <?php foreach ($items as $item) : ?>
                        <a href="<?= BASE_URL ?>/product?product_id=<?= $item['id'] ?>" class="text-decoration-none text-dark position-relative">
                            <form method="POST" action="<?= BASE_URL ?>/cart/remove-product" style="position: absolute; right: 0">
                                <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                <button class="bg-transparent"><i class="fa-regular fa-circle-xmark text-danger p-2"></i></button>
                            </form>
                            <div class="bg-light rounded-2 border mb-3 p-sm-3 p-2 d-flex">
                                <img src="<?= BASE_URL.$item['image'] ?>" alt="Plant in a pot" class="rounded-2" id="cartProductImage">
                                <div class="ms-4">
                                    <p class="fs-5"><?= $item['name'] ?></p>
                                    <p class="fs-5">$<?= $item['price'] ?></p>
                                    <p class="text-secondary mt-2">Quantity: <?= $item['quantity'] ?></p>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="fs-5">There are no items in your cart.</p>
                <?php endif; ?>
            </div>

            <div class="w-100">
                <h2 class="fw-bold mb-4">Summary</h2>
                <div class="border-bottom fw-bold">
                    <div class="d-flex justify-content-between">
                        <p>Subtotal</p>
                        <p><?= isset($_SESSION['cart']['total']) ? '$' . $_SESSION['cart']['total'] : '--' ?></p>
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
                        <p><?= isset($_SESSION['cart']['total']) ? '$' . $_SESSION['cart']['total'] : '--' ?></p>
                    </div>
                </div>

                <?php if (isset($_SESSION['cart'])) : ?>
                    <a href="<?= BASE_URL ?>/checkout" class="btn btn-success w-100 mt-4 py-2">Checkout</a>
                <?php else: ?>
                    <button class="btn btn-success w-100 mt-4 py-2" disabled>Checkout</button>
                <?php endif; ?>
                <a href="<?= BASE_URL ?>/shop" class="btn btn-outline-success w-100 mt-2 py-2">Shop More</a>
            </div>
        </div>
    </main>
    <?php include 'components/footer.php'; ?>
</body>