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
            </div>
        </main>
    <?php include 'components/footer.php'; ?>
</body>
