<?php
echo $this->extend('dashboard/sidebar');

echo $this->section('main');
?>
<main id="main" class="main">

    <section class="section dashboard">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header mx-4 mt-3">
                        <h3><?= $title ?></h3>
                    </div>
                    <div class="card-body">

                        <form action="<?= base_url('dashboard/update_kegiatan') ?>" method="POST">
                            <?= csrf_field(); ?>
                            <input type="hidden" value="<?= $kegiatan['id_kegiatan'] ?>" name="id_kegiatan">
                            <div class="row m-3 w-75">
                                <label for="nama_kegiatan" class="col-sm-3 col-form-label">Nama Kegiatan</label>
                                <div class="col-sm-9">
                                    <input type="text" name="nama_kegiatan" class="form-control" id="nama_kegiatan" value="<?= $kegiatan['nama_kegiatan'] ?>">
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="tanggal" class="col-sm-3 col-form-label">Tanggal Kegiatan</label>
                                <div class="col-sm-9">
                                    <input type="date" name="tanggal" class="form-control" id="tanggal" value="<?= $kegiatan['tanggal_kegiatan'] ?>">
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="tempat" class="col-sm-3 col-form-label">Tempat Kegiatan</label>
                                <div class="col-sm-9">
                                    <input type="text" name="tempat" class="form-control" id="tempat" value="<?= $kegiatan['tempat_kegiatan'] ?>">
                                </div>
                            </div>

                            <div class="row ms-4 w-75">
                                <button type="submit" class="col-3 me-2 btn btn-sm btn-primary">Simpan</button>
                                <a href="<?= base_url('dashboard/data_kegiatan') ?>" class="col-3 btn btn-secondary btn-sm">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Buat Konten Disini -->
        </div>
    </section>
</main>
<!-- End #main -->
<?= $this->endSection() ?>