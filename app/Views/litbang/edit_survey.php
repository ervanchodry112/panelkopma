<?php
echo $this->extend('dashboard/sidebar');
echo $this->section('main');
?>

<main id="main" class="main">
    <!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-12">
                <div class="card w-100">
                    <!-- Judul Page -->
                    <div class="card-header mx-3 mt-3">
                        <h3><?= $title ?></h3>
                    </div>
                    <!-- Judul Page -->
                    <div class="card-body my-3">

                        <!-- Alert hasil simpan -->
                        <?php
                        if (session()->getFlashdata('error')) {
                        ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                        } else if (session()->getFlashdata('success')) {
                        ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                        }
                        ?>
                        <!-- Alert hasil simpan -->

                        <!-- Form Edit Survey -->
                        <form action="<?= base_url('litbang/attempt_edit_survey') ?>" method="POST">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="id" value="<?= $survey->id ?>">
                            <div class="row m-3 w-75">
                                <label for="nama_survey" class="col-sm-3 col-form-label">Nama Survey</label>
                                <div class="col-sm-9">
                                    <input type="text" name="nama_survey" class="form-control <?= ($validation->hasError('nama_survey') ? 'is-invalid' : '') ?>" value="<?= $survey->nama_survey ?>" id="nama_survey" placeholder="Nama Survey" autofocus>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nama_survey') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
                                <div class="col-sm-9">
                                    <textarea name="deskripsi" id="deskripsi" placeholder="Deskripsi Survey" class="form-control <?= ($validation->hasError('deskripsi') ? 'is-invalid' : '') ?>"><?= $survey->deskripsi ?></textarea>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('deskripsi') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="tgl_mulai" class="col-sm-3 col-form-label">Tanggal Mulai</label>
                                <div class="col-sm-9">
                                    <input type="date" name="tgl_mulai" id="tgl_mulai" placeholder="DD/MM/YYYY" class="form-control <?= ($validation->hasError('tgl_mulai') ? 'is-invalid' : '') ?>" value="<?= $survey->tgl_mulai ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('tgl_mulai') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="tgl_selesai" class="col-sm-3 col-form-label">Tanggal Selesai</label>
                                <div class="col-sm-9">
                                    <input type="date" name="tgl_selesai" id="tgl_selesai" placeholder="DD/MM/YYYY" class="form-control <?= ($validation->hasError('tgl_selesai') ? 'is-invalid' : '') ?>" value="<?= $survey->tgl_selesai ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('tgl_selesai') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="link" class="col-sm-3 col-form-label">Link Survey</label>
                                <div class="col-sm-9">
                                    <input type="link" name="link" id="link" placeholder="http://" class="form-control <?= ($validation->hasError('link') ? 'is-invalid' : '') ?>" value="<?= $survey->link ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('link') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row ms-4 w-75">
                                <button type="submit" class="col-3 me-2 btn btn-sm btn-primary">Simpan</button>
                                <a href="<?= base_url('litbang/survey_berjalan') ?>" class="col-3 btn btn-secondary btn-sm">Batal</a>
                            </div>
                        </form>
                        <!-- Form edit Survey -->

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- End #main -->

<?= $this->endSection() ?>