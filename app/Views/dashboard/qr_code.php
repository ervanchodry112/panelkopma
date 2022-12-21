<?php

echo $this->extend('dashboard/sidebar');
echo $this->section('main');
?>
<main id="main" class="main">
    <!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header mx-3 mt-3">
                        <h3><?= $title ?></h3>

                    </div>
                    <div class="card-body">
                        <!-- Buat Konten Disini -->
                        <div class="row mx-2 my-3">
                            <div class="col d-flex justify-content-between">
                                <a href="<?= base_url('dashboard/data_kegiatan') ?>" class="link text-reset d-flex align-items-center">
                                    <ion-icon name="arrow-back-outline"></ion-icon>
                                    <span class="mx-1">Back</span>
                                </a>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row d-flex align-items-center mx-2 text-light">
                                <div class="col-sm-3 justify-content-center bg-primary p-3 rounded m-2">
                                    <img class="w-100 rounded mb-2 shadow" src="<?= base_url($file) ?>" width="250px" alt="">
                                    <a href="<?= base_url('dashboard/qr_download/' . $kegiatan['id_kegiatan']) ?>.png" class="btn btn-light w-100 shadow align-self-center">Download</a>
                                </div>
                                <div class="col-sm-8 m-2 bg-primary p-3 rounded lh-sm">
                                    <div class="row my-2 fw-bolder">
                                        <h3>Data Kegiatan</h3>
                                    </div>
                                    <div class="row my-2 mx-1">
                                        <hr>
                                    </div>
                                    <div class="row mb-3 fw-lighter fs-6">
                                        <div class="col-4">Nama Kegiatan</div>
                                        <div class="col-8">: <?= $kegiatan['nama_kegiatan'] ?></div>
                                    </div>
                                    <div class="row mb-3 fw-lighter fs-6">
                                        <div class="col-4">Tanggal Kegiatan</div>
                                        <div class="col-8">: <?= $kegiatan['tanggal_kegiatan'] ?></div>
                                    </div>
                                    <div class="row mb-3 fw-lighter fs-6">
                                        <div class="col-4">Tempat Kegiatan</div>
                                        <div class="col-8">: <?= $kegiatan['tempat_kegiatan'] ?></div>
                                    </div>
                                    <div class="row mb-3 fw-lighter fs-6">
                                        <div class="col-4">Status</div>
                                        <div class="col-8">: <?= $status ?></div>
                                    </div>
                                    <div class="row my-4 mx-1">
                                        <hr>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- End #main -->

<?= $this->endSection(); ?>