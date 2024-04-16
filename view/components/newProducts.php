<?php 
use App\Repositories\ProductRepo;

$productRepo = new ProductRepo();
$products = $productRepo->getNewest();
?>

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