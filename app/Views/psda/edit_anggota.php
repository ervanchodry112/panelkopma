<?php
echo $this->extend('dashboard/sidebar');

echo $this->section('main');
?>

<main>
    <div class="container p-0">
        <div class="row pt-3 mb-3">
            <div class="col">
                <h4 class="ps-3">Ubah Data Anggota</h4>
            </div>
            <hr>
        </div>
        <form action="<?= base_url('psda/update_anggota') ?>" method="POST">
            <?= csrf_field(); ?>
            <div class="row m-3 w-75">
                <label for="npm" class="col-sm-3 col-form-label">NPM</label>
                <div class="col-sm-9">
                    <input type="text" name="npm" class="form-control" id="npm" value="<?= $anggota['npm'] ?>" readonly>
                </div>
            </div>
            <div class="row m-3 w-75">
                <label for="nama" class="col-sm-3 col-form-label">Nama Lengkap</label>
                <div class="col-sm-9">
                    <input type="text" name="nama" class="form-control" id="nama" value="<?= $anggota['nama_lengkap'] ?>">
                </div>
            </div>
            <div class="row m-3 w-75">
                <label for="nomor_anggota" class="col-sm-3 col-form-label">Nomor Anggota</label>
                <div class="col-sm-9">
                    <input type="text" name="nomor_anggota" class="form-control" id="nomor_anggota" value="<?= $anggota['nomor_anggota'] ?>">
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
                <label for="jurusan" class="col-sm-3 col-form-label">Jurusan</label>
                <div class="col-sm-9">
                    <select class="form-select" name="jurusan" id="jurusan">
                        <option value="<?= $anggota['id_jurusan'] ?>" selected><?= $anggota['nama_jurusan'] ?></option>
                        <?php foreach ($jurusan as $jur) { ?>
                            <option value="<?= $jur['id_jurusan'] ?>"><?= $jur['nama_jurusan'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row ms-4 w-75">
                <button type="submit" class="col-3 me-2 btn btn-sm btn-primary">Simpan</button>
                <a href="<?= base_url('psda/data_anggota') ?>" class="col-3 btn btn-secondary btn-sm">Kembali</a>
            </div>
        </form>

    </div>
</main>
<?= $this->endSection() ?>