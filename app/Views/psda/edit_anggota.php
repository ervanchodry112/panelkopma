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

                        <form action="<?= base_url('psda/update_anggota') ?>" method="POST">
                            <?= csrf_field(); ?>
                            <div class="row m-3 w-75">
                                <label for="nomor_anggota" class="col-sm-3 col-form-label">Nomor Anggota</label>
                                <div class="col-sm-9">
                                    <input type="text" name="nomor_anggota" class="form-control" id="nomor_anggota" value="<?= $anggota['nomor_anggota'] ?>" readonly>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="npm" class="col-sm-3 col-form-label">NPM</label>
                                <div class="col-sm-9">
                                    <input type="text" name="npm" class="form-control" id="npm" value="<?= $anggota['npm'] ?>">
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="nama" class="col-sm-3 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-9">
                                    <input type="text" name="nama" class="form-control" id="nama" value="<?= $anggota['nama_lengkap'] ?>">
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" name="email" class="form-control" id="email" value="<?= $anggota['email'] ?>">
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="no_handphone" class="col-sm-3 col-form-label">Nomor Handphone</label>
                                <div class="col-sm-9">
                                    <input type="phone" name="no_handphone" class="form-control" id="no_handphone" value="<?= $anggota['nomor_hp'] ?>">
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="jenis_kelamin" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                <div class="col-sm-9">
                                    <select name="jenis_kelamin" class="form-select" id="jenis_kelamin" value="<?= $anggota['jenis_kelamin'] ?>">
                                        <option value="<?= $anggota['jenis_kelamin'] ?>" selected><?= $anggota['jenis_kelamin'] ?></option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="keanggotaan" class="col-sm-3 col-form-label">Status Keanggotaan</label>
                                <div class="col-sm-9">
                                    <select name="keanggotaan" class="form-select" id="keanggotaan" value="<?= $anggota['keanggotaan'] ?>">
                                        <option value="<?= $anggota['keanggotaan'] ?>" selected><?= $anggota['keanggotaan'] ?></option>
                                        <option value="Anggota">Anggota</option>
                                        <option value="Anggota Luar BIasa">Anggota Luar Biasa</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="jurusan" class="col-sm-3 col-form-label">Jurusan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control <?= ($validation->hasError('jurusan') ? 'is-invalid' : '') ?>" value="<?= $anggota['jurusan'] ?>" name="jurusan" id="jurusan">

                                    <div class="invalid-feedback">
                                        <?= $validation->getError('jurusan') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="fakultas" class="col-sm-3 col-form-label">Fakultas</label>
                                <div class="col-sm-9">
                                    <select type="text" class="form-select <?= ($validation->hasError('fakultas') ? 'is-invalid' : '') ?>" name="fakultas" id="fakultas">
                                        <option value="<?= $anggota['fakultas'] ?>" selected><?= $anggota['fakultas'] ?></option>
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
                                <button type="submit" class="col-3 me-2 btn btn-sm btn-primary">Simpan</button>
                                <a href="<?= base_url('psda/data_anggota') ?>" class="col-3 btn btn-secondary btn-sm">Kembali</a>
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