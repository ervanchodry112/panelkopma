<!-- Navbar -->
<?= $this->extend('layout/template') ?>(


<?= $this->section('sidebar'); ?>

<!-- Offcanvas -->
<div class="offcanvas offcanvas-start sidebar-nav bg-dark text-white overflow-auto" data-bs-scroll="true" data-bs-backdrop="true" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-body overflow-hidden p-0">
        <nav class="navbar-dark">
            <ul class="navbar-nav">
                <li class="my-1">
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a href="/dashboard" class="nav-link px-3 d-flex">
                        <span class="me-2">
                            <ion-icon style="font-size: 22px;" name="speedometer"></ion-icon>
                        </span>
                        <span>Dashboard</span>
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
                    <div class="row text-muted small fw-bold text-uppercase px-3" data-bs-toggle="collapse" href="#psdacollapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <span class="col-10">PSDA</span>
                        <span class="col-2">
                            <ion-icon name="caret-down-outline"></ion-icon>
                        </span>
                    </div>
                </li>
                <div id="psdacollapse" class="collapse">
                    <li>
                        <a href="/psda/calon_anggota" class="nav-link px-3 d-flex">
                            <span class="me-2">
                                <ion-icon style="font-size: 22px;" name="people"></ion-icon>
                            </span>
                            <span>Calon Anggota</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url('/psda/data_anggota/') ?>" class="nav-link px-3 d-flex">
                            <span class="me-2">
                                <ion-icon style="font-size: 22px;" name="people"></ion-icon>
                            </span>
                            <span>Data Anggota</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url('/psda/data_poin') ?>" class="nav-link px-3 d-flex">
                            <span class="me-2">
                                <ion-icon style="font-size: 22px;" name="checkmark-circle-outline"></ion-icon>

                            </span>
                            <span>Data Poin</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('/psda/kode_referal') ?>" class="nav-link px-3 d-flex">
                            <span class="me-2">
                                <ion-icon style="font-size: 22px;" name="gift-outline"></ion-icon>
                            </span>
                            <span>Kode Referal</span>
                        </a>
                    </li>
                </div>

                <li class="my-2">
                    <hr class="dropdown-divider">
                </li>


                <li>
                    <div class="row text-muted small fw-bold text-uppercase px-3" data-bs-toggle="collapse" href="#keuangan-collapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <span class="col-10">Keuangan</span>
                        <span class="col-2">
                            <ion-icon name="caret-down-outline"></ion-icon>
                        </span>
                    </div>
                </li>

                <div id="keuangan-collapse" class="collapse">

                    <li>
                        <a href="<?= base_url('/keuangan/data_simpanan') ?>" class="nav-link px-3 d-flex">
                            <span class="me-2">
                                <ion-icon style="font-size: 22px;" name="cash-outline"></ion-icon>
                            </span>
                            <span>Data Simpanan</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('/keuangan/pembayaran_simwa') ?>" class="nav-link px-3 d-flex">
                            <span class="me-2">
                                <ion-icon style="font-size: 22px;" name="cash-outline"></ion-icon>
                            </span>
                            <span>Pembayaran Simpanan</span>
                        </a>
                    </li>
                </div>


                <li class="my-2">
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <div class="row text-muted small fw-bold text-uppercase px-3" data-bs-toggle="collapse" href="#litbang-collapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <span class="col-10">Litbang</span>
                        <span class="col-2">
                            <ion-icon name="caret-down-outline"></ion-icon>
                        </span>
                    </div>
                </li>

                <div id="litbang-collapse" class="collapse">
                    <li>
                        <a href="<?= base_url('/dashboard/hasil_survey') ?>" class="nav-link px-3 d-flex">
                            <span class="me-2">
                                <ion-icon style="font-size: 22px;" name="chatbubbles-outline"></ion-icon>
                            </span>
                            <span>Hasil Survey</span>
                        </a>
                    </li>
                </div>

                <li class="my-2">
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <div class="row text-muted small fw-bold text-uppercase px-3" data-bs-toggle="collapse" href="#admin-collapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <span class="col-10">Administrasi</span>
                        <span class="col-2">
                            <ion-icon name="caret-down-outline"></ion-icon>
                        </span>
                    </div>
                </li>

                <div id="admin-collapse" class="collapse">
                    <li>
                        <a href="<?= base_url('/dashboard/surat_masuk') ?>" class="nav-link px-3 d-flex">
                            <span class="me-2">
                                <ion-icon style="font-size: 22px;" name="mail-open-outline"></ion-icon>
                            </span>
                            <span>Surat Masuk</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('/dashboard/surat_keluar') ?>" class="nav-link px-3 d-flex">
                            <span class="me-2">
                                <ion-icon style="font-size: 22px;" name="push-outline"></ion-icon>
                            </span>
                            <span>Surat Keluar</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('/dashboard/digilib') ?>" class="nav-link px-3 d-flex">
                            <span class="me-2">
                                <ion-icon style="font-size: 22px;" name="book-outline"></ion-icon>
                            </span>
                            <span>Digilib</span>
                        </a>
                    </li>
                </div>

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