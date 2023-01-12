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
                        <form action="<?= base_url('psda/save_anggota') ?>" method="POST">
                            <?= csrf_field(); ?>
                            <div class="row m-3 w-75">
                                <label for="npm" class="col-sm-3 col-form-label">NPM</label>
                                <div class="col-sm-9">
                                    <input type="text" name="npm" class="form-control <?= ($validation->hasError('npm') ? 'is-invalid' : '') ?>" value="<?= old('npm') ?>" id="npm" placeholder="npm" autofocus>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('npm') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="nama" class="col-sm-3 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-9">
                                    <input type="text" name="nama" id="nama" placeholder="Nama Lengkap" class="form-control <?= ($validation->hasError('nama') ? 'is-invalid' : '') ?>" value="<?= old('nama') ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nama') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="nomor_anggota" class="col-sm-3 col-form-label">Nomor Anggota</label>
                                <div class="col-sm-9">
                                    <input type="text" name="nomor_anggota" id="nomor_anggota" placeholder="Nomor Anggota" class="form-control <?= ($validation->hasError('nomor_anggota') ? 'is-invalid' : '') ?>" value="<?= old('nomor_anggota') ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nomor_anggota') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="jenis_kelamin" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                <div class="col-sm-9">
                                    <select type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-select <?= ($validation->hasError('jenis_kelamin') ? 'is-invalid' : '') ?>" value="<?= old('jenis_kelamin') ?>">
                                        <option selected>-- Jenis Kelamin --</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('jenis_kelamin') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" name="email" id="email" placeholder="Email" class="form-control <?= ($validation->hasError('email') ? 'is-invalid' : '') ?>" value="<?= old('email') ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('email') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="no_handphone" class="col-sm-3 col-form-label">Nomor Handphone</label>
                                <div class="col-sm-9">
                                    <input type="phone" name="no_handphone" id="no_handphone" placeholder="Nomor Handphone" class="form-control <?= ($validation->hasError('no_handphone') ? 'is-invalid' : '') ?>" value="<?= old('no_handphone') ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('no_handphone') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="status_keanggotaan" class="col-sm-3 col-form-label">Status Keanggotaan</label>
                                <div class="col-sm-9">
                                    <select class="form-select <?= ($validation->hasError('status_keanggotaan') ? 'is-invalid' : '') ?>" name="status_keanggotaan" id="status_keanggotaan">
                                        <option selected>-- Status Keanggotaan --</option>
                                        <option value="Anggota">Anggota</option>
                                        <option value="Anggota Luar Biasa">Anggota Luar Biasa</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('status_keanggotaan') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="jurusan" class="col-sm-3 col-form-label">Jurusan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control <?= ($validation->hasError('jurusan') ? 'is-invalid' : '') ?>" value="<?= old('jurusan') ?>" name="jurusan" id="jurusan">

                                    <div class="invalid-feedback">
                                        <?= $validation->getError('jurusan') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="fakultas" class="col-sm-3 col-form-label">Fakultas</label>
                                <div class="col-sm-9">
                                    <select type="text" class="form-select <?= ($validation->hasError('fakultas') ? 'is-invalid' : '') ?>" name="fakultas" id="fakultas">
                                        <option selected>-- Pilih Fakultas --</option>
                                        <option value="Fakultas Matematika dan Ilmu Pengetahuan Alam">Fakultas Matematika dan Ilmu Pengetahuan Alam</option>
                                        <option value="Fakultas Keguruan dan Ilmu Pendidikan">Fakultas Keguruan dan Ilmu Pendidikan</option>
                                        <option value="Fakultas Ilmu Sosial dan Ilmu Politik">Fakultas Ilmu Sosial dan Ilmu Politik</option>
                                        <option value="Fakultas Ekonomi dan Bisnis">Fakultas Ekonomi dan Bisnis</option>
                                        <option value="Fakultas Teknik">Fakultas Teknik</option>
                                        <option value="Fakultas Pertanian">Fakultas Pertanian</option>
                                        <option value="Fakultas Kedokteran">Fakultas Kedokteran</option>
                                        <option value="Fakultas Hukum">Fakultas Hukum</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('fakultas') ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row ms-4 w-75">
                                <button type="submit" class="col-3 me-2 btn btn-sm btn-primary">Tambah</button>
                                <a href="<?= base_url('psda/data_anggota') ?>" class="col-3 btn btn-secondary btn-sm">Batal</a>
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