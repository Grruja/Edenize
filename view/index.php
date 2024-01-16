<?php
include 'components/head.php';

use App\Models\Product;


$product = new Product();
$products = $product->getFour();
?>

<body>
<?php include 'components/navigationNoBg.php'; ?>
    <main>
        <div id="homeBgImg">
            <div id="homeTextContainer" class="container d-flex align-items-center justify-content-center">
                <div id="homeTextParent" class="text-center">
                    <h1 class="text-white col-lg-6 col-md-10 m-auto mb-4 fs-5">Elevate your space with our curated collection of vibrant plants, perfect for both beginners and plant enthusiasts. Transform your home with botanical beauty.</h1>
                    <a href="<?= BASE_URL ?>view/index.php" class="btn btn-success px-4 shadow">Shop now</a>
                </div>
            </div>
            <div id="homeInfoContainer" class="container d-sm-flex d-none justify-content-center gap-md-5 gap-4">
                <div class="text-white rounded-2 px-md-5 px-4 py-md-4 py-3" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(8px); height: fit-content">
                    <p class="fs-4">Free Delivery</p>
                    <p class="mb-1">Free shipping around the world</p>
                </div>
                <div class="text-white rounded-2 px-md-5 px-4 py-md-4 py-3" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(8px); height: fit-content">
                    <p class="fs-4">Friendly Service</p>
                    <p class="mb-1">You have 30 day return guarantee</p>
                </div>
            </div>
        </div>

        <div class="container mt-5">
            <div class="row row-cols-1 row-cols-md-4 row-cols-sm-2 g-4">
                <?php foreach ($products as $item) { ?>
                    <div class="col custom-col-xs-2">
                        <a href="product.php?product_id=<?= $item['id'] ?>" class="text-decoration-none text-dark w-100">
                            <div class="bg-light rounded-2 shadow p-4 h-100">
                                <h4 class="fw-bold fs-5"><?= $item['name'] ?></h4>
                                <p><?= $item['quantity'] ?> left</p>
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