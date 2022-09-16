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
                <h4 class="ps-3">Presensi Kegiatan</h4>
            </div>
            <hr>
        </div>
        <!-- Search Field -->
        <div class="row mx-2 mb-2">
            <div class="col d-flex justify-content-between">


                <div class="col d-flex align-items-center">
                    <a href="/psda/data_kegiatan" class="link text-reset d-flex align-items-center">
                        <ion-icon name="arrow-back-outline"></ion-icon>
                        <span class="mx-1">Back</span>
                    </a>


                    <!-- Search Field -->
                    <ion-icon name="search-outline" class="ms-auto"></ion-icon>
                    <form class="form w-25">
                        <input type="search" class="form-control d-flex rounded-pill ms-1" style="height: 28px;" placeholder="Search" aria-label="Search" id="fieldSearch" autocomplete="off">
                    </form>
                    <!-- Search Field -->
                </div>
            </div>
        </div>
        <!-- Search Field -->
        <div class="row mx-2 mb-4 p-3 rounded border border-top-0 border-end-0 border-bottom-0 border-4 border-info" style="background-color: #E1FFEE;">
            <div class="col-sm-6">

                <div class="row mb-2">
                    <div class="col-sm-5 text-column">Nama Kegiatan</div>
                    <div class="col-sm-7"><?= $kegiatan['nama_kegiatan'] ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5 text-column">Tanggal Kegiatan</div>
                    <div class="col-sm-7"><?= $kegiatan['tanggal_kegiatan'] ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5 text-column">Tempat Kegiatan</div>
                    <div class="col-sm-7"><?= $kegiatan['tempat_kegiatan'] ?></div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row mb-2">
                    <div class="col-sm-5 text-column">Jumlah Peserta</div>
                    <div class="col-sm-7"><?= count($data) ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-5 text-column">Status Kegiatan</div>
                    <div class="col-sm-7"><?= $status ?></div>
                </div>
            </div>
        </div>

        <div class="container overflow-scroll">
            <table class="table table-striped table-responsive tabel-data text-center w-100 fs-6" style="font-size: 12px;" id="tableData">
                <thead>
                    <tr>
                        <th scope="col">Action</th>
                        <th scope="col">Timestamp</th>
                        <th scope="col">Nama Lengkap</th>
                        <th scope="col">Nomor Anggota</th>
                    </tr>
                </thead>
                <?php foreach ($data as $d) { ?>
                    <tr id="<?= $d['npm'] ?>">
                        <td>
                            <a href="" type="button" class="btn btn-sm btn-success">
                                <ion-icon name="create-outline"></ion-icon>
                            </a>
                        </td>
                        <td><?= $d['waktu'] ?></td>
                        <td><?= $d['nama_lengkap'] ?></td>
                        <td><?= $d['nomor_anggota'] ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</main>

<?= $this->endSection(); ?>