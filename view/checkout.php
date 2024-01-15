<?php
include 'components/head.php';

use App\Models\Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Support\Session;

if (!Auth::check()) {
    header('Location: '.BASE_URL.'view/auth/login.php');
    exit();
}

Session::start();
if (!isset($_SESSION['cart'])) {
    header('Location: '.BASE_URL.'view/index.php');
    exit();
}

$cart = new Cart();
$items = $cart->get();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order = new Order();
    $order->make($_POST);
    $quantityErrors = $order->getQuantityErrors();
}
?>

<body>
<?php include 'components/navigation.php'; ?>
    <main class="container">
        <div class="d-flex flex-md-row flex-column gap-5">
            <div class="w-100">
                <?php if (isset($quantityErrors)) { ?>
                    <div class="alert alert-danger mb-4">
                        <?php foreach ($quantityErrors as $quantityError) { ?>
                            <p class="my-3"><?= $quantityError['message'] ?></p>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="shadow p-4 rounded-2">
                    <h3 class="mb-5 fw-bold">Shipping Details</h3>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" name="country" required class="form-control" id="country"
                                   value="<?= $_POST['country'] ?? null ?>">
                            <?php if (isset($errors['country'])) { ?>
                                <p class="text-danger"><?= $errors['country'] ?></p>
                            <?php } ?>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" required class="form-control" id="address"
                                   value="<?= $_POST['address'] ?? null ?>">
                            <?php if (isset($errors['address'])) { ?>
                                <p class="text-danger"><?= $errors['address'] ?></p>
                            <?php } ?>
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" name="city" required class="form-control" id="city"
                                   value="<?= $_POST['city'] ?? null ?>">
                            <?php if (isset($errors['city'])) { ?>
                                <p class="text-danger"><?= $errors['city'] ?></p>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-lg-8 col-sm-7">
                                <label for="state" class="form-label">State</label>
                                <input type="text" name="state" required class="form-control" id="state"
                                       value="<?= $_POST['state'] ?? null ?>">
                                <?php if (isset($errors['state'])) { ?>
                                    <p class="text-danger"><?= $errors['state'] ?></p>
                                <?php } ?>
                            </div>
                            <div class="mb-3 col-lg-4 col-sm-5">
                                <label for="zip" class="form-label">Zip</label>
                                <input type="text" name="zip" required class="form-control" id="zip"
                                       value="<?= $_POST['zip'] ?? null ?>">
                                <?php if (isset($errors['zip'])) { ?>
                                    <p class="text-danger"><?= $errors['zip'] ?></p>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-success py-3 w-100">Place Order</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="w-100">
                <h3 class="fw-bold mb-4">Cart Summary</h3>
                <div>
                    <?php foreach ($items as $item) { ?>
                        <div class="d-flex justify-content-between fw-bold mb-2">
                            <p><?= $item['quantity'] ?> x <?= $item['name'] ?></p>
                            <p>$<?= $item['price'] ?></p>
                        </div>
                    <?php } ?>
                </div>

                <div class="border-bottom border-top text-secondary">
                    <div class="d-flex justify-content-between mt-2">
                        <p>Subtotal</p>
                        <p><?= isset($_SESSION['cart']['total']) ? '$' . $_SESSION['cart']['total'] : '--' ?></p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Estimated Shipping & Handling</p>
                        <p>--</p>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <p>Estimated Tax</p>
                        <p>--</p>
                    </div>
                </div>

                <div class="border-bottom fw-bold">
                    <div class="d-flex justify-content-between my-2">
                        <p>Total</p>
                        <p><?= isset($_SESSION['cart']['total']) ? '$' . $_SESSION['cart']['total'] : '--' ?></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include 'components/footer.php'; ?>
</body>
