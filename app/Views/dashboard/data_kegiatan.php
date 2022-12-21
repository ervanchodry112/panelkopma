<?php
echo $this->extend('dashboard/sidebar');
echo $this->section('main');
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1><?= $title ?></h1>
        <nav>
            <ol class="breadcrumb">

            </ol>
        </nav>
    </div>
    <!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-12">
                <!-- Buat Konten Disini -->
                <div class="card">
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
                                            <th scope="col">Action</th>
                                            <th scope="col">Nama Kegiatan</th>
                                            <th scope="col">Lokasi</th>
                                            <th scope="col">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <?php foreach ($kegiatan as $d) { ?>
                                        <tr>
                                            <td>
                                                <a href="<?= base_url('dashboard/edit_kegiatan/' . $d['id_kegiatan']) ?>" type="button" class="btn btn-success btn-sm">
                                                    <ion-icon class="col" name="create-outline"></ion-icon>
                                                </a>
                                                <a href="<?= base_url('dashboard/presensi/' . $d['id_kegiatan']) ?>" type="button" class="btn btn-primary btn-sm">
                                                    <ion-icon class="col" name="clipboard-outline"></ion-icon>
                                                </a>
                                                <a href="<?= base_url('dashboard/kegiatan/' . $d['id_kegiatan']) ?>" class="btn btn-sm btn-warning">
                                                    <ion-icon name="qr-code-outline"></ion-icon>
                                                    </button>
                                            </td>
                                            <td>
                                                <?= $d['nama_kegiatan'] ?>
                                            </td>
                                            <td>
                                                <?= $d['tempat_kegiatan'] ?>
                                            </td>
                                            <td>
                                                <?= $d['tanggal_kegiatan'] ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
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