<?php
include 'components/head.php';

use App\Models\Product;

$product = new Product();

if (!isset($_GET['search_value'])) {
    $products = $product->all();

} else {
    $products = $product->search($_GET['search_value']);
}
?>

<body>
<?php include 'components/navigation.php'; ?>
<main class="container">
    <h1 class="text-center mb-5">All Plants</h1>

    <div class="border-bottom">
        <form method="GET" action="" class="d-flex mb-5" role="search">
            <input class="form-control me-2" name="search_value" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>

    <div class="mt-5 row row-cols-1 row-cols-md-4 row-cols-sm-2 g-4">
        <?php if (isset($products)) { ?>
            <?php foreach ($products as $item) { ?>
                <div class="col custom-col-xs-2">
                    <a href="product.php?product_id=<?= $item['id'] ?>" class="text-decoration-none text-dark w-100">
                        <div class="bg-light rounded-2 border p-lg-4 p-3 h-100">
                            <div class="d-flex justify-content-center mb-4">
                                <img src="<?= BASE_URL.$item['image'] ?>" alt="Plant in a pot" class="w-100 rounded-2">
                            </div>
                            <h4 class="fw-bold fs-5"><?= $item['name'] ?></h4>
                            <p><?= $item['quantity'] ?> left</p>
                            <p class="fw-bold text-success mt-3">$<?= $item['price'] ?></p>
                        </div>
                    </a>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="w-100 text-center text-secondary">
                <i class="fa-solid fa-magnifying-glass display-3"></i>
                <p class="fs-5 mt-4">No products found.</p>
            </div>
        <?php } ?>
    </div>
</main>
<?php include 'components/footer.php'; ?>
</body>