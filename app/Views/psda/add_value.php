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

                        <form action="<?= base_url('psda/sum_value') ?>" method="POST">
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
                                <a href="<?= base_url('psda/data_poin') ?>" class="col-3 btn btn-secondary btn-sm">Kembali</a>
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