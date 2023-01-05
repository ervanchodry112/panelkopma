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
                        <form action="<?= base_url('dashboard/save_progja') ?>" method="POST">
                            <?= csrf_field(); ?>
                            <div class="row m-3 w-75">
                                <label for="nama_program" class="col-sm-3 col-form-label">Nama Progja</label>
                                <div class="col-sm-9">
                                    <input type="text" name="nama_program" class="form-control <?= ($validation->hasError('nama_program') ? 'is-invalid' : '') ?>" value="<?= old('nama_program') ?>"" id=" nama_program" placeholder="Nama Program Kerja" autofocus>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nama_program') ?>
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
                                <label for="rencana_pelaksanaan" class="col-sm-3 col-form-label">Pelaksanaan</label>
                                <div class="col-sm-9">
                                    <input type="date" name="rencana_pelaksanaan" class="form-control <?= ($validation->hasError('rencana_pelaksanaan') ? 'is-invalid' : '') ?>" value="<?= old('rencana_pelaksanaan') ?>"" id=" rencana_pelaksanaan">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('rencana_pelaksanaan') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="status" class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    <select name="status" class="form-select <?= ($validation->hasError('status') ? 'is-invalid' : '') ?>" value="<?= old('status') ?>"" id=" status">
                                        <option selected>--Pilih Status--</option>
                                        <option value="Belum Terlaksana">Belum Terlaksana</option>
                                        <option value="Sudah Terlaksana">Sudah Terlaksana</option>
                                        <option value="Tidak Terlaksana">Tidak Terlaksana</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('status') ?>
                                    </div>
                                </div>
                            </div>

                            <?php
                            if (session()->getFlashdata('pesan')) { ?>
                                <div class="row ms-4 w-75">
                                    <div class="col-12 alert alert-success" role="alert">
                                        Data berhasil ditambahkan!
                                    </div>
                                </div>
                            <?php
                                session()->remove('pesan');
                            }
                            ?>

                            <div class="row ms-4 w-75">
                                <button type="submit" class="col-3 me-2 btn btn-sm btn-primary">Tambah</button>
                                <a href="<?= base_url('dashboard/program_kerja') ?>" class="col-3 btn btn-secondary btn-sm">Batal</a>
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