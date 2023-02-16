<!-- Navbar -->
<?= $this->extend('layout/template') ?>(


<?= $this->section('sidebar'); ?>


<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <div class="logo d-flex align-items-center">
            <img src="<?= base_url('/img/logo-kopma-unila.png') ?>" alt="Kopma Unila" />
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
            <a class="nav-link collapsed" href="<?= base_url('/') ?>">
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
        if (user()->username != 'panitia') {
        ?>
            <li class="nav-item">
                <div class="nav-heading">Pengurus</div>
                <a href="<?= base_url('/dashboard/program_kerja') ?>" class="nav-link collapsed px-3 d-flex">
                    <i class="bi bi-clipboard"></i>
                    <span>Program Kerja</span>
                </a>
            </li>
            <li class="my-1">
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
                    <a href="<?= base_url('administrasi/surat_masuk') ?>" class="nav-link collapsed px-3 d-flex">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span>Surat Masuk</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('administrasi/surat_keluar') ?>" class="nav-link collapsed px-3 d-flex">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Surat Keluar</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('administrasi/digilib') ?>" class="nav-link collapsed px-3 d-flex">
                        <i class="bi bi-book"></i>
                        <span>Digilib</span>
                    </a>
                </li>
            </div>
            <li class="my-1">
                <hr>
            </li>
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
                <div class="nav-heading">Usaha</div>
                <a href="<?= base_url('usaha/produk') ?>" class="nav-link collapsed px-3 d-flex">
                    <i class="bi bi-box-seam"></i>
                    <span>Produk</span>
                </a>
            </li>
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
                <li class="nav-item">
                    <a href="<?= base_url('keuangan/laporan_keuangan') ?>" class="nav-link collapsed px-3 d-flex">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        <span>Laporan Keuangan</span>
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
                    <a href="<?= base_url('litbang/survey_berjalan') ?>" class="nav-link collapsed px-3 d-flex">
                        <i class="bi bi-clipboard2-data"></i>
                        <span>Survey Berjalan</span>
                    </a>
                </li>
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
            <?php
            if (in_groups('admin')) {
            ?>
                <li class="nav-heading">Admin</li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/data_user') ?>" class="nav-link collapsed px-3 d-flex">
                        <i class="bi bi-person-gear"></i>
                        <span>Akun</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/akun_juko') ?>" class="nav-link collapsed px-3 d-flex">
                        <i class="bi bi-people"></i>
                        <span>Akun Si Juko</span>
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