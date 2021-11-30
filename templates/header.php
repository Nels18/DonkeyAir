<header class="p-3">
    <nav class="row justify-content-between">
        <div class="col px-5">DonkeyAir</div>
        <ul class="nav nav-pills col justify-content-end">
            <li class="nav-item">
                <a class="nav-link <?php
                if ('/index.php' == htmlspecialchars($_SERVER["PHP_SELF"])) {
                    echo "active";
                }; ?>" href="index.php">Rechercher un vol</a>
            </li>
            <li class="nav-item <?php
                if ('/my-bookings.php' == htmlspecialchars($_SERVER["PHP_SELF"])) {
                    echo "active";
                }; ?>">
                <a class="nav-link" href="my-bookings">Mes réservation</a>
            </li>
        </ul>
    </nav>
</header>