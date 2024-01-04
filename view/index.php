<?php
    include 'components/head.php';
    use App\models\Product;

    $product = new Product();
    $products = $product->fetchFour();
?>

<body>
<?php include 'components/navigation.php'; ?>
    <main>
        <div class="container">
            <h1>Welcome!</h1>

            <div class="row row-cols-1 row-cols-md-4 row-cols-sm-2 g-4">
                <?php foreach ($products as $item) { ?>
                    <div class="col custom-col-xs-2">
                        <a href="product.php?product_id=<?= $item['id'] ?>" class="text-decoration-none text-dark w-100">
                            <div id="cardContainer" class="bg-light rounded-2 shadow p-4 h-100">
                                <h4 class="fw-bold fs-5"><?= $item['name'] ?></h4>
                                <p><?= $item['quantity'] ?> left</p>
                                <div id="cardPriceContainer" class="d-flex justify-content-between">
                                    <p class="fs-5 fw-bold">$<?= $item['price'] ?></p>
                                    <a href="index.php" class="btn btn-success d-flex align-items-center">
                                        <i class="fa-solid fa-cart-arrow-down"></i>
                                    </a>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>
<?php include 'components/footer.php'; ?>
</body>