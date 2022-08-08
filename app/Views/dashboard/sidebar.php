<!-- Navbar -->
<?= $this->extend('layout/template') ?>(


<?= $this->section('sidebar'); ?>
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
<!-- Navbar -->

<!-- Offcanvas -->
<div class="offcanvas offcanvas-start sidebar-nav bg-dark text-white" data-bs-scroll="true" data-bs-backdrop="true" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-body p-0">
        <nav class="navbar-dark">
            <ul class="navbar-nav">
                <li class="my-2">
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <div class="text-muted small fw-bold text-uppercase px-3">
                        psda
                    </div>
                </li>
                <!-- <li>
                        <a href="index.php" class="nav-link px-3 d-flex">
                            <span class="me-2">
                                <ion-icon style="font-size: 22px;" name="people"></ion-icon>
                            </span>
                            <spa>Pendaftaran Anggota</span>
                        </a>
                    </li> -->
                <li>
                    <a href="<?= base_url('/dashboard/data_anggota/') ?>" class="nav-link px-3 d-flex">
                        <span class="me-2">
                            <ion-icon style="font-size: 22px;" name="people"></ion-icon>
                        </span>
                        <span>Data Anggota</span>
                    </a>
                </li>

                <li>
                    <a href="<?= base_url('/dashboard/data_poin') ?>" class="nav-link px-3 d-flex">
                        <span class="me-2">
                            <ion-icon style="font-size: 22px;" name="people"></ion-icon>
                        </span>
                        <span>Data Poin</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('/dashboard/data_kegiatan') ?>" class="nav-link px-3 d-flex">
                        <span class="me-2">
                            <ion-icon style="font-size: 22px;" name="calendar-clear-outline"></ion-icon>
                        </span>
                        <span>Data Kegiatan</span>
                    </a>
                </li>
                <li class="my-2">
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <div class="text-muted small fw-bold text-uppercase px-3">
                        Keuangan
                    </div>
                </li>

                <li>
                    <a href="<?= base_url('/dashboard/data_simpanan') ?>" class="nav-link px-3 d-flex">
                        <span class="me-2">
                            <ion-icon style="font-size: 22px;" name="people"></ion-icon>
                        </span>
                        <span>Data Simpanan</span>
                    </a>
                </li>

                <li class="my-2">
                    <hr class="dropdown-divider">
                </li>
                <?php //if ($_SESSION['role'] == 3) { 
                ?>
                <li>
                    <a href="<?= base_url('/dashboard/akun') ?>" class="nav-link px-3 d-flex">
                        <span class="me-2">
                            <ion-icon style="font-size: 22px;" name="people"></ion-icon>
                        </span>
                        <span>Akun</span>
                    </a>
                </li>
                <?php //} 
                ?>
            </ul>
        </nav>
    </div>
</div>

<?= $this->renderSection('main'); ?>
<!-- Offcanvas -->
<?= $this->endSection(); ?>