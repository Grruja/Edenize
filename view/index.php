<?php
include 'components/head.php';

use App\Controllers\ProductController;

$productController = new ProductController();
$products = $productController->displayNewest();
?>

<body>
<?php include 'components/navigation.php'; ?>
    <main>
        <div id="homeBgImg">
            <div class="container d-flex align-items-center h-100">
                <div id="homeTextBg" class="text-md-start text-center col-lg-6 py-5 bg-success">
                    <div id="homeText" class="ms-xxl-0 ms-md-5">
                        <h1 class="text-white fs-2">BEST <span class="fw-bold display-5">HOUSE </span><span class="fw-bold display-1 d-block">PLANTS</span></h1>
                        <p class="text-white fs-5 col-sm-7 col-11 m-lg-0 m-auto text-lg-start text-center">Bring a touch of nature into your home with our beautiful collection of plants.</p>
                        <a href="<?= BASE_URL ?>view/shop.php" class="d-lg-inline-block d-none btn btn-outline-light px-5 py-2 mt-4">Shop Now</a>
                        <a href="<?= BASE_URL ?>view/shop.php" class="d-lg-none d-inline-block btn btn-success px-5 py-2 mt-4">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container d-flex flex-sm-row flex-column gap-md-5 gap-3" style="margin-top: 6rem; margin-bottom: 6rem">
            <div class="d-flex flex-lg-row flex-sm-column gap-5 align-items-center border border-dark p-4 rounded-2">
                <div class="col-lg-2 col-sm-6 col-2">
                    <img class="w-100" src="<?= BASE_URL.'public/assets/free_shipping.png' ?>" alt="Truck with a free shipping text">
                </div>
                <div>
                    <h2 class="fs-4">Fast and Free Delivery</h2>
                    <p>Free delivery for all orders</p>
                </div>
            </div>
            <div class="d-flex flex-lg-row flex-sm-column gap-5 align-items-center border border-dark p-4 rounded-2">
                <div class="col-lg-2 col-sm-6 col-2">
                    <img class="w-100" src="<?= BASE_URL.'public/assets/customer_support.png' ?>" alt="Headphones with a microphone">
                </div>
                <div>
                    <h2 class="fs-4">24/7 Customer Support</h2>
                    <p>Friendly 24/7 customer support</p>
                </div>
            </div>
            <div class="d-flex flex-lg-row flex-sm-column gap-5 align-items-center border border-dark p-4 rounded-2">
                <div class="col-lg-2 col-sm-6 col-2">
                    <img class="w-100" src="<?= BASE_URL.'public/assets/gift.png' ?>" alt="Gift">
                </div>
                <div>
                    <h2 class="fs-4">Member Gifts</h2>
                    <p>Discount coupons weekends</p>
                </div>
            </div>
        </div>

        <div id="aboutParent" class="py-1">
            <div id="aboutChild" class="container d-flex justify-content-md-between justify-content-center" style="margin-top: 6rem; margin-bottom: 6rem">
                <div class="col-5 d-md-block d-none">
                    <img class="w-100" src="<?= BASE_URL .'public/assets/plant_gardening.png' ?>" alt="Close-up hands gardening plant">
                </div>
                <div class="col-md-6 text-md-start text-center">
                    <h2 class="mb-md-5 mb-3">Shop Edenize</h2>
                    <p>Edenize offers a unique selection of handcrafted plant products, each designed to bring a touch of nature into your living space. Our creations are more than just plants – they are living art pieces that transcend traditional planters. Whether you choose to suspend a kokedama mid-air, hang a botanical masterpiece on your wall, or make a living sculpture the centerpiece of your tabletop, each Edenize creation is a distinctive work of art.</p>
                    <p class="mt-5 d-lg-block d-none">Every piece from Edenize is made to order, ensuring that you receive a bespoke item crafted with care and attention to detail. Our team of skilled artisans infuses each creation with a unique personality, making it a perfect fit for your home. Embrace the beauty of nature with our one-of-a-kind masterpieces that seamlessly blend art and plant life.</p>
                </div>
            </div>
        </div>

        <div class="container mt-5">
            <h2 class="mb-5">New Plants</h2>
            <div class="row row-cols-1 row-cols-md-4 row-cols-sm-2 g-4">
                <?php foreach ($products as $item) : ?>
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
                <?php endforeach; ?>
            </div>
        </div>
    </main>
<?php include 'components/footer.php'; ?>
</body>