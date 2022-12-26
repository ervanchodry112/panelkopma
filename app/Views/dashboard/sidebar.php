<!-- Navbar -->
<?= $this->extend('layout/template') ?>(


<?= $this->section('sidebar'); ?>


<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top w-100">
    <div class="container-fluid">
        Offcanvas Trigerr
        <button class="navbar-toggler me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <span class="navbar-toggler-icon" data-bs-target="#offcanvasExample"></span>
        </button>
        Offcanvas Trigerr
        <a class="navbar-brand d-flex align-items-center me-auto " href="#">
            <img class="me-2" height="40px" src="<?= base_url('/img/logo-kopma-unila.png') ?>" alt="">
            KOPMA UNILA
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0 ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="me-2 d-none d-lg-inline text-gray-600 sm">
                            <?= ucwords(user()->username) ?>
                        </span>
                    </a>

                    <ul class="dropdown-menu" style="left: -100px;" aria-labelledby="navbarDropdown">
                        <li class="nav-item"><a class="dropdown-item" href="<?= base_url('dashboard/logout') ?>">LogOut</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>  -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <div class="logo d-flex align-items-center">
            <img src="/img/logo-kopma-unila.png" alt="Kopma Unila" />
            <span class="d-none d-lg-block">Kopma Unila</span>
        </div>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <!-- End Logo -->

</header>
<!-- End Header -->



<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-heading">Main</li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('dashboard') ?>">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <!-- End Dashboard Nav -->


        <li class="nav-item">
            <a href="<?= base_url('/dashboard/data_kegiatan') ?>" class="nav-link collapsed px-3 d-flex">
                <i class="bi bi-calendar"></i>
                <span>Data Kegiatan</span>
            </a>
        </li>
        <li class="my-1">

            <hr>
        </li>

        <?php
        if (!in_groups('anggota')) {
        ?>
            <li class="nav-item">
                <div class="nav-heading">PSDA</div>
                <div class="row text-muted small fw-bold text-uppercase px-3" data-bs-toggle="collapse" href="#psdacollapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <span class="col-10">PSDA</span>
                    <span class="col-2">
                        <i class="bi bi-chevron-down"></i>
                    </span>
                </div>
            </li>
            <div id="psdacollapse" class="collapse">
                <li class="nav-item">
                    <a href="<?= base_url('psda/calon_anggota') ?>" class="nav-link collapsed px-3 d-flex">
                        <i class="bi bi-person-fill-add"></i>
                        <span>Calon Anggota</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('psda/data_anggota/') ?>" class="nav-link collapsed px-3 d-flex">
                        <i class="bi bi-people-fill"></i>
                        <span>Data Anggota</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('psda/data_poin') ?>" class="nav-link collapsed px-3 d-flex">
                        <i class="bi bi-coin"></i>
                        <span>Data Poin</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('psda/kode_referal') ?>" class="nav-link collapsed px-3 d-flex">
                        <i class="bi bi-gift-fill"></i>
                        <span>Kode Referal</span>
                    </a>
                </li>
            </div>

            <li class="my-1">
                <hr>
            </li>


            <li class="nav-item">
                <div class="nav-heading">Keuangan</div>
                <div class="row text-muted small fw-bold text-uppercase px-3" data-bs-toggle="collapse" href="#keuangan-collapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <span class="col-10">Keuangan</span>
                    <span class="col-2">
                        <i class="bi bi-chevron-down"></i>
                    </span>
                </div>
            </li>

            <div id="keuangan-collapse" class="collapse">

                <li class="nav-item">
                    <a href="<?= base_url('keuangan/data_simpanan') ?>" class="nav-link collapsed px-3 d-flex">
                        <i class="bi bi-cash-stack"></i>
                        <span>Data Simpanan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('keuangan/pembayaran_simwa') ?>" class="nav-link collapsed px-3 d-flex">
                        <i class="bi bi-receipt-cutoff"></i>
                        <span>Pembayaran Simpanan</span>
                    </a>
                </li>
            </div>

            <li class="my-1">
                <hr>
            </li>

            <li class="nav-item">
                <div class="nav-heading">Litbang</div>
                <div class="row text-muted small fw-bold text-uppercase px-3" data-bs-toggle="collapse" href="#litbang-collapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <span class="col-10">Litbang</span>
                    <span class="col-2">
                        <i class="bi bi-chevron-down"></i>
                    </span>
                </div>
            </li>

            <div id="litbang-collapse" class="collapse">
                <li class="nav-item">
                    <a href="<?= base_url('litbang/hasil_survey') ?>" class="nav-link collapsed px-3 d-flex">
                        <i class="bi bi-clipboard2-data"></i>
                        <span>Hasil Survey</span>
                    </a>
                </li>
            </div>

            <li class="my-2">
                <hr>
            </li>

            <li class="nav-item">
                <div class="nav-heading">Administrasi</div>
                <div class="row text-muted small fw-bold text-uppercase px-3" data-bs-toggle="collapse" href="#admin-collapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <span class="col-10">Administrasi</span>
                    <span class="col-2">
                        <i class="bi bi-chevron-down"></i>
                    </span>
                </div>
            </li>

            <div id="admin-collapse" class="collapse">
                <li class="nav-item">
                    <a href="<?= base_url('dashboard/surat_masuk') ?>" class="nav-link collapsed px-3 d-flex">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span>Surat Masuk</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('dashboard/surat_keluar') ?>" class="nav-link collapsed px-3 d-flex">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Surat Keluar</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('dashboard/digilib') ?>" class="nav-link collapsed px-3 d-flex">
                        <i class="bi bi-book"></i>
                        <span>Digilib</span>
                    </a>
                </li>
            </div>

            <li class="my-2">
                <hr>
            </li>
            <?php
            if (in_groups('admin')) {
            ?>
                <li class="nav-heading">Admin</li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/data_user') ?>" class="nav-link collapsed px-3 d-flex">
                        <i class="bi bi-person-fill-gear"></i>
                        <span>Akun</span>
                    </a>
                </li>
        <?php
            }
        }
        ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= base_url('/logout') ?>">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>

</aside>
<!-- End Sidebar-->


<?= $this->renderSection('main'); ?>
<!-- Offcanvas -->
<?= $this->endSection(); ?>