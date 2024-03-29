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
                    <div class="card-body my-3">
                        <!-- Buat Konten Disini -->
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
                            <div class="col-3">
                                <div class="ms-3">
                                    <a href="<?= base_url('administrasi/add_surat_keluar') ?>" class="btn btn-sm btn-primary w-75 justify-content-center d-flex align-items-center">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        Tambah Surat
                                    </a>
                                </div>

                            </div>
                            <div class="col-4 ms-auto">
                                <form action="<?= base_url('administrasi/surat_keluar') ?>" method="post" class="d-flex align-items-center">
                                    <button type="submit" class="btn btn-sm btn-white">
                                        <i class="bi bi-search"></i>
                                    </button>
                                    <input type="search" name="search" id="search" class="form-control rounded-pill" placeholder="Search" autocomplete="FALSE">
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-striped table-responsive tabel-data text-center w-100 fs-6" style="font-size: 12px;" id="tableData">
                                    <thead>
                                        <tr>
                                            <th scope="col">No. Surat</th>
                                            <th scope="col">Isi Surat</th>
                                            <th scope="col">Tujuan Surat</th>
                                            <th scope="col">Tanggal Surat</th>
                                            <th scope="col">Kode</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    if ($surat_keluar == null) {
                                        echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
                                    } else {
                                        foreach ($surat_keluar as $d) {
                                    ?>
                                            <tr>
                                                <td>
                                                    <?= $d->no_surat ?>
                                                </td>
                                                <td>
                                                    <?= $d->isi_surat ?>
                                                </td>
                                                <td>
                                                    <?= $d->tujuan ?>
                                                </td>
                                                <td>
                                                    <?= date_format(date_create($d->tgl_surat), 'd M Y') ?>
                                                </td>
                                                <td>
                                                    <?= $d->kode ?>
                                                </td>
                                                <td class="d-flex align-items-center justify-content-evenly">
                                                    <a href="<?= base_url('administrasi/edit_surat_keluar/' . $d->id_surat) ?>" type="button" class="btn btn-warning btn-sm">
                                                        <ion-icon class="col" name="create-outline"></ion-icon>
                                                    </a>
                                                    <a href="<?= base_url('administrasi/view_surat_keluar/' . $d->file) ?>" type="button" class="btn btn-primary btn-sm" target="_blank">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <form action="<?= base_url('administrasi/delete_surat_keluar') ?>" method="post">
                                                        <input type="hidden" name="id_surat" value="<?= $d->id_surat ?>">
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
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
        </div>
    </section>
</main>
<!-- End #main -->

<?= $this->endSection() ?>