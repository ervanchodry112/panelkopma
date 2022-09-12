<?php
echo $this->extend('dashboard/sidebar');

echo $this->section('main');
?>

<main>
    <div class="container p-0">
        <div class="row pt-3 mb-3">
            <div class="col">
                <h4 class="ps-3">Tambah Data Kegiatan</h4>
            </div>
            <hr>
        </div>
        <form action="save_kegiatan" method="POST">
            <?= csrf_field(); ?>
            <div class="row m-3 w-75">
                <label for="nama_kegiatan" class="col-sm-3 col-form-label">Nama Kegiatan</label>
                <div class="col-sm-9">
                    <input type="text" name="nama_kegiatan" class="form-control" id="nama_kegiatan" placeholder="Nama Kegiatan" autofocus>
                </div>
            </div>
            <div class="row m-3 w-75">
                <label for="tanggal" class="col-sm-3 col-form-label">Tanggal Kegiatan</label>
                <div class="col-sm-9">
                    <input type="date" name="tanggal" class="form-control" id="tanggal" placeholder="Nama Lengkap">
                </div>
            </div>
            <div class="row m-3 w-75">
                <label for="tempat" class="col-sm-3 col-form-label">Tempat Kegiatan</label>
                <div class="col-sm-9">
                    <input type="text" name="tempat" class="form-control" id="tempat" placeholder="Tempat Kegiatan">
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
            }
            ?>

            <div class="row ms-4 w-75">
                <button type="submit" class="col-3 me-2 btn btn-sm btn-primary">Tambah</button>
                <a href="data_kegiatan" class="col-3 btn btn-secondary btn-sm">Batal</a>
            </div>
        </form>

    </div>
</main>
<?= $this->endSection() ?>