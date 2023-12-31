<header class="position-absolute top-0 w-100">
    <?php
        use App\models\Auth;


        session_status() == PHP_SESSION_NONE ? session_start() : null;

        if (isset($_SESSION['alert_message'])) { ?>
            <div id="alert" class="alert alert-success position-fixed text-center start-50 translate-middle-x mt-3" style="z-index: 2" role="alert">
                <?php
                    echo $_SESSION['alert_message'];
                    unset($_SESSION['alert_message']);
                ?>
            </div>
    <?php } ?>

    <style>
        a {
            color: white !important;
        }
    </style>

    <nav class="navbar navbar-expand-lg" style="z-index: 10">
        <div class="container">
            <a class="navbar-brand py-2 d-lg-block d-none" href="<?= BASE_URL ?>view/index.php">
                <img src="<?= BASE_URL ?>public/assets/edenize_logo_white.png" alt="Edenize logo" width="120">
            </a>
            <button class="navbar-toggler p-1 border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars fs-2 text-white"></i>
            </button>
            <?php if (Auth::isLogged()) { ?>
                <li class="nav-item d-lg-none d-block py-2">
                    <a class="nav-link" href="<?= BASE_URL ?>view/index.php">
                        <i class="fa-solid fa-cart-shopping fs-4 text-white"></i>
                    </a>
                </li>
            <?php } ?>
            <?php if (!Auth::isLogged()) { ?>
                <div class="navbar-nav d-lg-none d-flex flex-row gap-2">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>view/auth/login.php">
                            <span class="btn btn-outline-light">Login</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>view/auth/register.php">
                            <span class="btn btn-success">Register</span>
                        </a>
                    </li>
                </div>
            <?php } ?>
            <div class="collapse navbar-collapse rounded-2" id="navbarNav">
                <ul class="navbar-nav d-flex justify-content-between align-items-lg-center ms-lg-5 px-4 py-3 w-100">
                    <div class="d-flex flex-lg-row gap-lg-4 flex-column align-items-lg-center">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>view/index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>view/index.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>view/index.php">Products</a>
                        </li>
                    </div>
                    <div class="d-flex flex-lg-row flex-column align-items-lg-center">
                        <?php if (!Auth::isLogged()) { ?>
                            <li class="nav-item d-lg-block d-none">
                                <a class="nav-link" href="<?= BASE_URL ?>view/auth/login.php">
                                    <span class="btn btn-outline-light">Login</span>
                                </a>
                            </li>
                            <li class="nav-item d-lg-block d-none">
                                <a class="nav-link" href="<?= BASE_URL ?>view/auth/register.php">
                                    <span class="btn btn-success">Register</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if (Auth::isLogged()) { ?>
                            <li class="nav-item me-4">
                                <a class="nav-link" href="<?= BASE_URL ?>view/auth/logout.php">
                                    <span>
                                    <i class="fa-solid fa-arrow-right-from-bracket text-white me-1"></i>
                                        Logout
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item d-lg-block d-none">
                                <a class="nav-link" href="<?= BASE_URL ?>view/index.php">
                                    <i class="fa-solid fa-cart-shopping fs-4 text-white"></i>
                                </a>
                            </li>
                        <?php } ?>
                    </div>
                </ul>
            </div>
        </div>
    </nav>

    <script>
        const alert = document.getElementById('alert');

        if (alert) {
            displayAlert();
        }

        function displayAlert() {
            setTimeout(() => {
                alert.remove();
            }, 5000);
        }
    </script>

</header>