<header class="mb-5">

<?php
use App\Models\Auth;
use App\Support\Session;


Session::start();

if (isset($_SESSION['alert_message']['success'])) { ?>
    <div id="alert" class="alert alert-success position-fixed text-center start-50 translate-middle-x mt-3" style="z-index: 2" role="alert">
        <?php
        echo $_SESSION['alert_message']['success'];
        unset($_SESSION['alert_message']['success']);
        ?>
    </div>
<?php } else if (isset($_SESSION['alert_message']['danger'])) { ?>
    <div id="alert" class="alert alert-danger position-fixed text-center start-50 translate-middle-x mt-3" style="z-index: 2" role="alert">
        <?php
        echo $_SESSION['alert_message']['danger'];
        unset($_SESSION['alert_message']['danger']);
        ?>
    </div>
<?php } ?>

    <nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm">
        <div class="container">
            <a class="navbar-brand py-2 d-lg-block d-none" href="<?= BASE_URL ?>view/index.php">
                <img src="<?= BASE_URL ?>public/assets/edenize_logo_black.png" alt="Edenize logo" width="120">
            </a>
            <button class="navbar-toggler p-1 border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars fs-2 text-success"></i>
            </button>
            <?php if (Auth::check()) { ?>
                <li class="nav-item d-lg-none d-block py-2">
                    <a class="nav-link" href="<?= BASE_URL ?>view/cart.php">
                        <?php if (isset($_SESSION['cart'])) { ?>
                            <img src="<?= BASE_URL ?>public/assets/cart/full_cart_black.svg" alt="Full cart icon" width="32">
                        <?php } else { ?>
                            <img src="<?= BASE_URL ?>public/assets/cart/cart_black.svg" alt="Cart icon" width="26">
                        <?php } ?>
                    </a>
                </li>
            <?php } ?>
            <?php if (!Auth::check()) { ?>
                <div class="navbar-nav d-lg-none d-flex flex-row gap-2">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>view/auth/login.php">
                            <span class="btn btn-outline-success">Login</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>view/auth/register.php">
                            <span class="btn btn-success">Register</span>
                        </a>
                    </li>
                </div>
            <?php } ?>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav d-flex justify-content-between align-items-lg-center ms-lg-5 ms-2 w-100">
                    <div class="d-flex flex-lg-row gap-lg-4 flex-column align-items-lg-center">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>view/index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>view/shop.php">Shop</a>
                        </li>
                    </div>
                    <div class="d-flex flex-lg-row flex-column align-items-lg-center">
                        <?php if (!Auth::check()) { ?>
                            <li class="nav-item d-lg-block d-none">
                                <a class="nav-link" href="<?= BASE_URL ?>view/auth/login.php">
                                    <span class="btn btn-outline-success">Login</span>
                                </a>
                            </li>
                            <li class="nav-item d-lg-block d-none">
                                <a class="nav-link" href="<?= BASE_URL ?>view/auth/register.php">
                                    <span class="btn btn-success">Register</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (Auth::check()) { ?>
                            <li class="nav-item me-4">
                                <form method="POST" action="<?= BASE_URL ?>view/auth/logout.php" class="nav-link">
                                    <button class="bg-transparent nav-link">
                                    <i class="fa-solid fa-arrow-right-from-bracket me-1"></i>
                                        Logout
                                    </button>
                                </form>
                            </li>
                            <li class="nav-item d-lg-block d-none">
                                <a class="nav-link" href="<?= BASE_URL ?>view/cart.php">
                                    <?php if (isset($_SESSION['cart'])) { ?>
                                        <img src="<?= BASE_URL ?>public/assets/cart/full_cart_black.svg" alt="Full cart icon" width="32">
                                    <?php } else { ?>
                                        <img src="<?= BASE_URL ?>public/assets/cart/cart_black.svg" alt="Cart icon" width="26">
                                    <?php } ?>
                                </a>
                            </li>
                        <?php } ?>
                    </div>
                </ul>
            </div>
        </div>
    </nav>
</header>