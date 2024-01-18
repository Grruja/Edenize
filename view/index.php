<?php
include 'components/head.php';

use App\Models\Product;


$product = new Product();
$products = $product->getNewest();
?>

<body>
<?php include 'components/navigationNoBg.php'; ?>
    <main>
        <div id="homeBgImg">
            <div id="homeTextContainer" class="container d-flex align-items-center justify-content-center">
                <div id="homeTextParent" class="text-center">
                    <h1 class="text-white col-lg-6 col-md-10 m-auto mb-4 fs-5">Elevate your space with our curated collection of vibrant plants, perfect for both beginners and plant enthusiasts. Transform your home with botanical beauty.</h1>
                    <a href="<?= BASE_URL ?>view/shop.php" class="btn btn-success px-5 py-2 border">Shop Now</a>
                </div>
            </div>
            <div id="homeInfoContainer" class="container d-sm-flex d-none justify-content-center gap-md-5 gap-4">
                <div class="text-white border border-secondary rounded-2 px-md-5 px-4 py-md-4 py-3 d-flex gap-4 align-items-center" style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(8px); height: fit-content">
                    <div class="col-lg-2 col-3 d-md-block d-none">
                        <img class="w-75" src="<?= BASE_URL.'public/assets/free_shipping.png' ?>" alt="Delivered package">
                    </div>
                    <div>
                        <p class="fs-5">Free Delivery</p>
                        <p class="mb-1">Free shipping around the world</p>
                    </div>
                </div>
                <div class="text-white border border-secondary rounded-2 px-md-5 px-4 py-md-4 py-3 d-flex gap-4 align-items-center" style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(8px); height: fit-content">
                    <div class="col-lg-2 col-3 d-md-block d-none">
                        <img class="w-75" src="<?= BASE_URL.'public/assets/friendly_service.png' ?>" alt="Hand with a smile">
                    </div>
                    <div>
                        <p class="fs-5">Friendly Service</p>
                        <p class="mb-1">You have 30 day return guarantee</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container d-flex justify-content-md-between justify-content-center" style="margin-top: 6rem; margin-bottom: 6rem">
            <div class="col-5 d-md-block d-none">
                <img class="w-100" src="<?= BASE_URL .'public/assets/plant_gardening.png' ?>" alt="Close-up hands gardening plant">
            </div>
            <div class="col-md-6 text-md-start text-center">
                <h2 class="mb-md-5 mb-3">Shop Edenize</h2>
                <p>Edenize offers a unique selection of handcrafted plant products, each designed to bring a touch of nature into your living space. Our creations are more than just plants – they are living art pieces that transcend traditional planters. Whether you choose to suspend a kokedama mid-air, hang a botanical masterpiece on your wall, or make a living sculpture the centerpiece of your tabletop, each Edenize creation is a distinctive work of art.</p>
                <p class="mt-5 d-lg-block d-none">Every piece from Edenize is made to order, ensuring that you receive a bespoke item crafted with care and attention to detail. Our team of skilled artisans infuses each creation with a unique personality, making it a perfect fit for your home. Embrace the beauty of nature with our one-of-a-kind masterpieces that seamlessly blend art and plant life.</p>
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