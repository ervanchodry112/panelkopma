<?php
echo $this->extend('dashboard/sidebar');

echo $this->section('main');
?>

<main>
    <div class="container p-0">
        <div class="row pt-3 mb-3">
            <div class="col">
                <h4 class="ps-3">Tambah Poin</h4>
            </div>
            <hr>
        </div>
        <form action="/psda/sum_value" method="POST">
            <?= csrf_field(); ?>
            <div class="row m-3 w-75">
                <label for="nama_lengkap" class="col-sm-3 col-form-label">Nama Lengkap</label>
                <div class="col-sm-9">
                    <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" value="<?= $anggota['nama_lengkap'] ?>" readonly>
                </div>
            </div>
            <div class="row m-3 w-75">
                <label for="nomor_anggota" class="col-sm-3 col-form-label">Nomor Anggota</label>
                <div class="col-sm-9">
                    <input type="text" name="nomor_anggota" class="form-control" id="nomor_anggota" value="<?= $anggota['nomor_anggota'] ?>" readonly>
                </div>
            </div>
            <div class="row m-3 w-75">
                <label for="poin" class="col-sm-3 col-form-label">Tambah</label>
                <div class="col-sm-9 w-75 input-group">
                    <input type="text" name="poin" class="form-control" id="poin" placeholder="0" autofocus>
                    <span class="input-group-text" id="basic-addon3">Poin</span>
                </div>
            </div>



            <div class="row ms-4 w-75">
                <button type="submit" class="col-3 me-2 btn btn-sm btn-primary">Tambah</button>
                <a href="/psda/data_poin" class="col-3 btn btn-secondary btn-sm">Kembali</a>
            </div>
        </form>

    </div>
</main>
<?= $this->endSection() ?>