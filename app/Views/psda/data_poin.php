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

                        <div class="row mx-2 mb-2">
                            <div class="col d-flex justify-content-between">
                                <div class="col d-flex align-items-center">
                                    <button class="btn btn-success border-start fs-6" type="button" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                        <i class="bi bi-upload me-1"></i>
                                        XLSX
                                    </button>

                                    <!-- Search Field -->

                                    <ion-icon name="search-outline" class="ms-auto"></ion-icon>
                                    <form class=" form w-25">
                                        <input name="search" type="search" class="form-control d-flex rounded-pill ms-1" style="height: 28px;" placeholder="Search" aria-label="Search" id="fieldSearch" autocomplete="off">
                                    </form>
                                    <!-- Search Field -->
                                    <a href="<?= base_url('psda/download_poin') ?>" class="btn btn-success btn-sm text-white d-flex ms-3 align-items-center me-2 rounded-3">
                                        <i class="bi bi-download me-1"></i>
                                        XLSX
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                        if (session()->getFlashdata('pesan')) {
                        ?>
                            <div class="row mx-2">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?= session()->getFlashData('pesan') ?>
                                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        <?php
                            session()->remove('pesan');
                        }
                        ?>
                        <div class="container overflow-scroll">
                            <table class="table table-striped table-responsive tabel-data text-center w-100 fs-6" style="font-size: 12px;" id="tableData">
                                <thead>
                                    <tr>
                                        <th scope="col">Action</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Nomor Anggota</th>
                                        <th scope="col">Poin</th>
                                    </tr>
                                </thead>
                                <?php foreach ($data as $d) { ?>
                                    <tr>
                                        <td>
                                            <a href="<?= base_url('psda/add_value/' . $d['nomor_anggota']) ?>" type="button" class="btn btn-sm btn-warning">
                                                <ion-icon name="add-outline"></ion-icon>
                                        </td>
                                        <td><?= $d['nama_lengkap'] ?></td>
                                        <td><?= $d['nomor_anggota'] ?></td>
                                        <td><?= $d['poin'] + (int) (($d['simpanan_wajib'] / 10000) * 3) ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Upload Excel</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('psda/upload_poin') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body mx-2">
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-danger text-center" role="alert">
                                <strong>Perhatian!</strong> Poin anggota akan ditambahkan sesuai jumlah poin yang ada dalam file!.
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3 d-flex align-items-center">
                            <label for="file">File Excel</label>
                        </div>
                        <div class="col-9">
                            <input type="file" name="file" id="file" class="form-control">
                            <div class="text-muted" style="font-size: .8em;">*sesuaikan format file seperti template dibawah</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 d-flex align-items-center">
                            Template
                        </div>
                        <div class="col-9">
                            <a href="<?= base_url('assets/uploads/document/template/template_poin.xlsx') ?>" target="_blank" class="btn btn-primary btn-sm">
                                <i class="bi bi-download ms-1"></i>
                                Download
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End #main -->

<?= $this->endSection(); ?>