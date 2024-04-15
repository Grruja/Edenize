<?php
include 'components/head.php';

use App\Controllers\ProductController;

$productController = new ProductController();
$products = $productController->searchByName();
?>

<body>
<?php include 'components/navigation.php'; ?>
<main>
    <div id="shopBgImg">
        <h1 class="text-center py-5 text-white">All Plants</h1>
    </div>

    <div class="container mt-5">
        <div class="border-bottom">
            <form method="GET" action="" class="d-flex mb-5" role="search">
                <input class="form-control me-2" name="search_value" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-success" type="submit">Search</button>
            </form>
        </div>

        <div class="mt-5 row row-cols-1 row-cols-md-4 row-cols-sm-2 g-4">
            <?php if (isset($products)) : ?>
                <?php foreach ($products as $item) : ?>
                    <div class="col custom-col-xs-2">
                        <a href="product?product_id=<?= $item['id'] ?>" class="text-decoration-none text-dark w-100">
                            <div class="bg-light rounded-2 border p-lg-4 p-3 h-100">
                                <div class="d-flex justify-content-center mb-4">
                                    <img src="<?= $publicPath.$item['image'] ?>" alt="Plant in a pot" class="w-100 rounded-2">
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
                <?php endforeach; ?>
            <?php else: ?>
                <div class="w-100 text-center text-secondary">
                    <i class="fa-solid fa-magnifying-glass display-3"></i>
                    <p class="fs-5 mt-4">No products found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>
<?php include 'components/footer.php'; ?>
</body>