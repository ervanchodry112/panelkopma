<?php

echo $this->extend('dashboard/sidebar');
echo $this->section('main');

?>

<main id="main" class="main">

    <section class="section dashboard">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header mx-3 mt-2">
                        <h3><?= $title ?></h3>

                    </div>

                    <div class="card-body">

                        <div class="row mx-2 my-3">
                            <div class="col-12 d-flex justify-content-between align-items-center">
                                <a href="<?= base_url('dashboard/add_participant/' . $kegiatan['id_kegiatan']) ?>" class="btn btn-sm btn-primary me-3">
                                    <i class="bi bi-plus-circle me-1"></i>
                                    Tambah Peserta
                                </a>
                                <a href="<?= base_url('dashboard/data_kegiatan') ?>" class="link text-reset d-flex align-items-center">
                                    <ion-icon name="arrow-back-outline"></ion-icon>
                                    <span class="mx-1">Back</span>
                                </a>


                                <!-- Search Field -->
                                <ion-icon name="search-outline" class="ms-auto"></ion-icon>
                                <form class="form w-25">
                                    <input type="search" class="form-control d-flex rounded-pill ms-1" style="height: 28px;" placeholder="Search" aria-label="Search" id="fieldSearch" autocomplete="off">
                                </form>
                                <!-- Search Field -->

                                <!-- Download Button -->
                                <a href="<?= base_url('dashboard/download_presensi/' . $kegiatan['id_kegiatan']) ?>" class="btn btn-success btn-sm p-auto rounded-pill shadow-sm d-flex justify-content-center ms-3" style="width: 10%;">
                                    <span class="me-1">
                                        <ion-icon style="font-size: 16px;" name="download-outline"></ion-icon>
                                    </span>
                                    <span>
                                        XLS
                                    </span>
                                </a>
                                <!-- Download Button -->
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
                                    <div class="col-sm-7"><?= date_format(date_create($kegiatan['tanggal_kegiatan']), 'd M Y')  ?></div>
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
                                        <th scope="col">#</th>
                                        <th scope="col">Timestamp</th>
                                        <th scope="col">Nama Lengkap</th>
                                        <th scope="col">Nomor Anggota</th>
                                        <th scope="col">Jabatan</th>
                                    </tr>
                                </thead>
                                <?php $i = 1 + (25 * ($current_page - 1));
                                foreach ($data as $d) { ?>
                                    <tr id="<?= $d['npm'] ?>">
                                        <th scope="row"><?= $i++ ?></th>
                                        <td><?= $d['waktu'] ?></td>
                                        <td><?= $d['nama_lengkap'] ?></td>
                                        <td><?= $d['nomor_anggota'] ?></td>
                                        <td><?= $d['keanggotaan'] ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                            <?= $pager->links('presensi', 'custom_pagination') ?>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="id_kegiatan" id="id_kegiatan" value="<?= $kegiatan['id_kegiatan'] ?>">
            <!-- Buat Konten Disini -->
            <h1 id="test"></h1>
        </div>
    </section>
</main>
<!-- End #main -->


<?= $this->endSection(); ?>