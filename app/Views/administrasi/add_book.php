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
                        <form action="<?= base_url('administrasi/save_book') ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="row m-3 w-75">
                                <label for="judul" class="col-sm-3 col-form-label">Judul Buku</label>
                                <div class="col-sm-9">
                                    <input type="text" name="judul" class="form-control <?= ($validation->hasError('judul') ? 'is-invalid' : '') ?>" value="<?= old('judul') ?>"" id=" judul" placeholder="Judul Buku" autofocus>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('judul') ?>
                                    </div>
                                </div>

                            </div>
                            <div class="row m-3 w-75">
                                <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
                                <div class="col-sm-9">
                                    <textarea name="deskripsi" class="form-control <?= ($validation->hasError('deskripsi') ? 'is-invalid' : '') ?>" id=" deskripsi" placeholder="Deskripsi"><?= old('deskripsi') ?></textarea>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('deskripsi') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="file" class="col-sm-3 col-form-label">File</label>
                                <div class="col-sm-9">
                                    <input type="file" name="file" id="file" class="form-control <?= ($validation->hasError('lpj') ? 'is-invalid' : '') ?>" value="<?= old('file') ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('kode') ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row ms-4 w-75">
                                <button type="submit" class="col-3 me-2 btn btn-sm btn-primary">Tambah</button>
                                <a href="<?= base_url('administrasi/digilib') ?>" class="col-3 btn btn-secondary btn-sm">Batal</a>
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