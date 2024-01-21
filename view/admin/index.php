<?php
include '../components/head.php';

use App\Models\Auth;
use App\Models\Product;

if (!Auth::isUserAdmin()) {
    header('Location: '.BASE_URL.'view/404.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product = new Product();
    $product->create($_POST, $_FILES['image']);
}
?>

<body>
    <?php include '../components/navigation.php'; ?>
    <main class="container mt-5">
        <h1>Admin</h1>
        <div class="d-flex justify-content-center mt-5">
            <div class="border bg-light p-5 rounded-2 col-xxl-5 col-xl-6 col-lg-7 col-md-9">
                <form method="POST" action="" enctype="multipart/form-data">
                    <h2 class="text-center mb-5">Create Product</h2>
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" name="name" required class="form-control" id="name">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" name="price" required class="form-control" id="price">
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Available Quantity</label>
                        <input type="number" name="quantity" required class="form-control" id="quantity">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" cols="30" rows="10" required class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input name="image" type="file" required accept="image/*" class="form-control" id="image">
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-success">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <?php include '../components/footer.php'; ?>
</body>