<?php
include 'components/head.php';

use App\Models\Auth;
use App\Models\Cart;
use App\Models\Product;


$product = new Product();
$permalink = $product->permalink($_GET['product_id']);

$products = $product->getNewest();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!Auth::check()) {
        header('Location: '.BASE_URL.'view/auth/login.php');
        exit();
    }

    $cart = new Cart();
    $cart->add($permalink['id'], $_POST['quantity'] ?? null);
}
?>

<body>
    <?php include 'components/navigation.php'; ?>
    <main>
        <div class="container d-flex flex-sm-row flex-column gap-5">
            <div class="col-sm-6">
                <img class="w-100 rounded-2" style="max-width: 500px"  src="<?= BASE_URL.$permalink['image'] ?>" alt="Plant in a pot">
            </div>
            
            <div class="col-sm-6">
                <h1><?= $permalink['name'] ?></h1>
                <p><?= $permalink['description'] ?></p>
                <?php if ($permalink['quantity'] == 0) : ?>
                    <span class="border border-danger text-danger p-1 fs-bold" style="font-size: 10px">SOLD OUT</span>
                <?php else: ?>
                    <p class="mt-3">Left in stock: <?= $permalink['quantity'] ?></p>
                <?php endif; ?>
                <p class="fs-2 my-4">$<?= $permalink['price'] ?></p>
    
                <form method="POST" action="">
                    <div class="d-flex align-items-center gap-3">
                        <label for="quantity" class="form-label fw-bold">Quantity:</label>
                        <div class="col-md-2 col-sm-3 custom-col-xs-quantity">
                            <input type="number" name="quantity" value="1" required class="form-control" id="quantity">
                        </div>
                    </div>
                    <button class="btn btn-success mt-3" <?= $permalink['quantity'] == 0 ? 'disabled' : null ?>>Add to Cart</button>
                </form>
            </div>
        </div>

        <div class="container mt-5">
            <h2 class="mb-5">New Plants</h2>
            <div class="row row-cols-1 row-cols-md-4 row-cols-sm-2 g-4">
                <?php foreach ($products as $item) { ?>
                    <div class="col custom-col-xs-2">
                        <a href="product.php?product_id=<?= $item['id'] ?>" class="text-decoration-none text-dark w-100">
                            <div class="bg-light rounded-2 border p-lg-4 p-3 h-100">
                                <div class="d-flex justify-content-center mb-4">
                                    <img src="<?= BASE_URL.$item['image'] ?>" alt="Plant in a pot" class="w-100 rounded-2">
                                </div>
                                <p class="fw-bold fs-5"><?= $item['name'] ?></p>
                                <?php if ($item['quantity'] == 0) : ?>
                                    <span class="border border-danger text-danger p-1 fs-bold" style="font-size: 10px">SOLD OUT</span>
                                <?php else: ?>
                                    <p><?= $item['quantity'] ?> left</p>
                                <?php endif; ?>
                                <p class="fw-bold text-success mt-3">$<?= $item['price'] ?></p>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>
    <?php include 'components/footer.php'; ?>
</body>