<?php
    include 'components/head.php';
    use App\models\Product;


    $product = new Product();
    $permalink = $product->permalink($_GET['product_id']);
?>

<body>
    <?php include 'components/navigation.php'; ?>
    <main>
        <div class="container">
            <h1><?= $permalink['name'] ?></h1>
        </div>
    </main>
    <?php include 'components/footer.php'; ?>
</body>