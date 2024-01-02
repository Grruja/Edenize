<header class="mb-5">
    <?php
    session_status() == PHP_SESSION_NONE ? session_start() : null;

    if (isset($_SESSION['alert_message'])) { ?>
        <div id="alert" class="alert alert-success position-fixed text-center start-50 translate-middle-x mt-3" style="z-index: 2" role="alert">
            <?php
                echo $_SESSION['alert_message'];
                unset($_SESSION['alert_message']);
            ?>
        </div>
    <?php } ?>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="../public/assets/edenize_logo.png" alt="Edenize logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
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
            }, 4000);
        }
    </script>

</header>