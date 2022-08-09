<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top w-100">
    <div class="container-fluid">
        <!-- Offcanvas Trigerr -->
        <button class="navbar-toggler me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <span class="navbar-toggler-icon" data-bs-target="#offcanvasExample"></span>
        </button>
        <!-- Offcanvas Trigerr -->
        <a class="navbar-brand d-flex me-auto" href="#">
            <img class="me-2" height="40px" src="<?= base_url('/img/logo-kopma-unila.png') ?>" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0 ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span>
                            <ion-icon style="font-size: 26px;" name="person-circle-outline"></ion-icon>
                        </span>
                    </a>

                    <ul class="dropdown-menu" style="left: -100px;" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="logout.php">LogOut</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>