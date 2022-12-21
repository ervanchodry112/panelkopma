<?php

use Config\Validation;

echo $this->extend('dashboard/sidebar');

echo $this->section('main');
// dd($errors);

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
                        <form action="<?= base_url('litbang/save_report') ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="row m-3 w-75">
                                <label for="nama_survey" class="col-sm-3 col-form-label">Nama Survey</label>
                                <div class="col-sm-9">
                                    <input type="text" name="nama_survey" id="nama_survey" placeholder="Nama Survey" autofocus class="form-control <?= ($validation->hasError('nama_survey') ? 'is-invalid' : '') ?>" value="<?= old('nama_survey') ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nama_survey') ?>
                                    </div>
                                </div>

                            </div>

                            <div class="row m-3 w-75">
                                <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi Survey</label>
                                <div class="col-sm-9">
                                    <input type="text" name="deskripsi" id="deskripsi" placeholder="Deskripsi Survey" class="form-control <?= ($validation->hasError('deskripsi') ? 'is-invalid' : '') ?>" value="<?= old('deskripsi') ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('deskripsi') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="tanggal_mulai" class="col-sm-3 col-form-label">Tanggal Mulai</label>
                                <div class="col-sm-9">
                                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" placeholder="Tanggal Mulai" class="form-control <?= ($validation->hasError('tanggal_mulai') ? 'is-invalid' : '') ?>" value="<?= old('tanggal_mulai') ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('tanggal_mulai') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="tanggal_selesai" class="col-sm-3 col-form-label">Tanggal Selesai</label>
                                <div class="col-sm-9">
                                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" placeholder="Tanggal Selesai" class="form-control <?= ($validation->hasError('tanggal_selesai') ? 'is-invalid' : '') ?>" value="<?= old('tanggal_selesai') ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('tanggal_selesai') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="file" class="col-sm-3 col-form-label">Upload File</label>
                                <div class="col-sm-9">
                                    <input type="file" name="file" id="file" class="form-control <?= ($validation->hasError('file') ? 'is-invalid' : '') ?>" value="<?= old('file') ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('file') ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row ms-4 w-75">
                                <button type="submit" class="col-3 me-2 btn btn-sm btn-primary">Tambah</button>
                                <a href="<?= base_url('litbang/hasil_survey') ?>" class="col-3 btn btn-secondary btn-sm">Batal</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- End #main -->


<?= $this->endSection() ?>