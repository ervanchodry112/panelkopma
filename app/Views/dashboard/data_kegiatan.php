<?php
echo $this->extend('dashboard/sidebar');
echo $this->section('main');
?>

<main id="main" class="main">


    <section class="section dashboard">
        <div class="row">
            <div class="col-12">
                <!-- Buat Konten Disini -->
                <div class="card p-3">
                    <div class="card-header">

                        <h2><?= $title ?></h2>
                    </div>
                    <div class="card-body py-3 my-2">
                        <?php
                        if (session()->getFlashdata('success')) { ?>
                            <div class="row mx-1">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <span><?= session()->getFlashdata('success') ?></span>
                                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        <?php

                        } else if (session()->getFlashdata('error')) {
                        ?>
                            <div class="row mx-1">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <span><?= session()->getFlashdata('error') ?></span>
                                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                        <div class="row mb-2">
                            <div class="col-12">
                                <a href="<?= base_url('dashboard/add_kegiatan') ?>" class="btn btn-sm btn-primary">
                                    <i class="bi bi-plus-circle"></i>
                                    <span>Tambah Kegiatan</span>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-striped table-responsive tabel-data text-center w-100 fs-6" style="font-size: 12px;" id="tableData">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nama Kegiatan</th>
                                            <th scope="col">Lokasi</th>
                                            <th scope="col">Tanggal</th>
                                            <th scope="col">Arsip Kegiatan</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    if ($kegiatan == null) {
                                        echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
                                    } else {
                                        foreach ($kegiatan as $d) {
                                    ?>
                                            <tr>
                                                <td>
                                                    <?= $d['nama_kegiatan'] ?>
                                                </td>
                                                <td>
                                                    <?= $d['tempat_kegiatan'] ?>
                                                </td>
                                                <td>
                                                    <?= $d['tanggal_kegiatan'] ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($d['link'] != null) {
                                                    ?>
                                                        <a href="<?= $d['link'] ?>" class="btn btn-primary btn-sm" target="_blank">
                                                            <i class="bi bi-box-arrow-up-right"></i>
                                                        </a>
                                                    <?php
                                                    }
                                                    ?>
                                                    <a href="<?= base_url('dashboard/presensi/' . $d['id_kegiatan']) ?>" type="button" class="btn btn-success btn-sm">
                                                        <ion-icon class="col" name="clipboard-outline"></ion-icon>
                                                    </a>
                                                    <a href="<?= base_url('dashboard/kegiatan/' . $d['id_kegiatan']) ?>" class="btn btn-sm btn-info">
                                                        <ion-icon name="qr-code-outline"></ion-icon>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-12 d-flex align-items-center justify-content-evenly">
                                                            <a href="<?= base_url('dashboard/edit_kegiatan/' . $d['id_kegiatan']) ?>" type="button" class="btn btn-warning btn-sm">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>
                                                            <form action="<?= base_url('dashboard/delete_kegiatan') ?>" method="post">
                                                                <input type="hidden" name="id_kegiatan" id="id_kegiatan" value="<?= $d['id_kegiatan'] ?>">
                                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </table>
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