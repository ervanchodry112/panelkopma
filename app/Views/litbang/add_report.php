<?php

use Config\Validation;

echo $this->extend('dashboard/sidebar');

echo $this->section('main');
// dd($errors);

?>

<main>
    <div class="container p-0">
        <div class="row pt-3 mb-3">
            <div class="col">
                <h4 class="ps-3">Tambah Hasil Survey</h4>
            </div>
            <hr>
        </div>
        <form action="/litbang/save_report" method="POST" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="row m-3 w-75">
                <label for="nama_survey" class="col-sm-3 col-form-label">Nama Survey</label>
                <div class="col-sm-9">
                    <input type="text" name="nama_survey" class="form-control" id="nama_survey" placeholder="Nama Survey" autofocus>
                    <div class="invalid-feedback">
                    </div>
                </div>

            </div>

            <div class="row m-3 w-75">
                <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi Survey</label>
                <div class="col-sm-9">
                    <input type="text" name="deskripsi" class="form-control" id="deskripsi" placeholder="Deskripsi Survey">
                </div>
            </div>
            <div class="row m-3 w-75">
                <label for="tanggal_mulai" class="col-sm-3 col-form-label">Tanggal Mulai</label>
                <div class="col-sm-9">
                    <input type="date" name="tanggal_mulai" class="form-control" id="tanggal_mulai" placeholder="Tanggal Mulai">
                </div>
            </div>
            <div class="row m-3 w-75">
                <label for="tanggal_selesai" class="col-sm-3 col-form-label">Tanggal Selesai</label>
                <div class="col-sm-9">
                    <input type="date" name="tanggal_selesai" class="form-control" id="tanggal_selesai" placeholder="Tanggal Selesai">
                </div>
            </div>
            <div class="row m-3 w-75">
                <label for="file" class="col-sm-3 col-form-label">Upload File</label>
                <div class="col-sm-9">
                    <input type="file" name="file" class="form-control" id="file">
                </div>
            </div>

            <div class="row ms-4 w-75">
                <button type="submit" class="col-3 me-2 btn btn-sm btn-primary">Tambah</button>
                <a href="/litbang/hasil_survey" class="col-3 btn btn-secondary btn-sm">Batal</a>
            </div>
        </form>

    </div>
</main>
<?= $this->endSection() ?>