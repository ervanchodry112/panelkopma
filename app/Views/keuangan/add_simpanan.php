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
                    <div class="card-body">
                        <!-- Buat Konten Disini -->
                        <form action="<?= base_url('keuangan/save_simpanan') ?>" method="POST">
                            <?= csrf_field(); ?>
                            <div class="row m-3 w-75">
                                <label for="npm" class="col-sm-4 col-form-label">NPM</label>
                                <div class="col-sm-8 w-50">
                                    <input type="text" name="npm" class="form-control" id="npm" value="<?= $npm ?>" disabled>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="nama" class="col-sm-4 col-form-label">Nama</label>
                                <div class="col-sm-8 w-50">
                                    <input type="text" name="nama" class="form-control" id="nama" value="<?= $nama['nama_lengkap'] ?>" disabled>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="nominal" class="col-sm-4 form-label">Nominal Pembayaran</label>
                                <div class="col-sm-8 input-group w-50">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" name="nominal" class="form-control" id="nominal" placeholder="0" autofocus>
                                </div>
                            </div>
                            <div class="row ms-4 w-75">
                                <button type="submit" class="col-3 me-2 btn btn-sm btn-primary">Tambah</button>
                                <a href="<?= base_url('keuangan/data_simpanan') ?>" class="col-3 btn btn-secondary btn-sm">Batal</a>
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