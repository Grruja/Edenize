<?php
/* @var array $product
 * @var array $products
 */

include 'components/head.php';
?>

<body>
    <?php include 'components/navigation.php'; ?>
    <main class="mt-5">
        <div class="container d-flex flex-sm-row flex-column gap-5">
            <div class="col-sm-6">
                <img class="w-100 rounded-2" style="max-width: 500px"  src="<?= $publicPath.$product['image'] ?>" alt="Plant in a pot">
            </div>
            
            <div class="col-sm-6">
                <h1><?= $product['name'] ?></h1>
                <p><?= $product['description'] ?></p>
                <?php if ($product['quantity'] == 0) : ?>
                    <span class="border border-danger text-danger p-1 fs-bold" style="font-size: 10px">SOLD OUT</span>
                <?php else: ?>
                    <p class="mt-3">Left in stock: <?= $product['quantity'] ?></p>
                <?php endif; ?>
                <p class="fs-2 my-4">$<?= $product['price'] ?></p>
    
                <form method="POST" action="<?= $baseUrl ?>/cart/add-product">
                    <div class="d-flex align-items-center gap-3">
                        <label for="quantity" class="form-label fw-bold">Quantity:</label>
                        <div class="col-md-2 col-sm-3 custom-col-xs-quantity">
                            <input type="number" name="quantity" value="1" required class="form-control" id="quantity">
                        </div>
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>" required>
                    </div>
                    <button class="btn btn-success mt-3" <?= $product['quantity'] == 0 ? 'disabled' : null ?>>Add to Cart</button>
                </form>
            </div>
        </div>

        <div class="container mt-5">
            <h2 class="mb-5">New Plants</h2>
            <div class="row row-cols-1 row-cols-md-4 row-cols-sm-2 g-4">
                
                <?php include 'components/newProducts.php'; ?>

            </div>
        </div>
    </main>
    <?php include 'components/footer.php'; ?>
</body>