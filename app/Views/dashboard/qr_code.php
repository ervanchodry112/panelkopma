<?php

echo $this->extend('dashboard/sidebar');
echo $this->section('main');

$tgl_kegiatan = new DateTime($kegiatan['tanggal_kegiatan']);
$today = new DateTime();

if ($tgl_kegiatan < $today) {
    $status = 'Selesai';
} else {
    $status = 'Belum Selesai';
}
?>

<main>
    <div class="container p-0">
        <div class="row pt-3 mb-3">
            <div class="col">
                <h4 class="ps-3">QR Code Presensi</h4>
            </div>
            <hr>
        </div>
        <div class="row mx-2 mb-2">
            <div class="col d-flex justify-content-between">
                <a href="/dashboard/data_kegiatan" class="link text-reset d-flex align-items-center">
                    <ion-icon name="arrow-back-outline"></ion-icon>
                    <span class="mx-1">Back</span>
                </a>
            </div>
        </div>
        <div class="container">
            <div class="row d-flex align-items-center mx-2 text-light">
                <div class="col-sm-3 justify-content-center bg-primary p-3 rounded m-2">
                    <img class="w-100 rounded mb-2 shadow" src="<?= base_url($file) ?>" width="250px" alt="">
                    <a href="/dashboard/qr_download/<?= $kegiatan['id_kegiatan'] ?>.png" class="btn btn-light w-100 shadow align-self-center">Download</a>
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
</main>

<?= $this->endSection(); ?>