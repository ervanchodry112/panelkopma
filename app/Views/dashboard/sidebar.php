<!-- Navbar -->
<?= $this->extend('layout/template') ?>(


<?= $this->section('sidebar'); ?>

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