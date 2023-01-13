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
                        <form action="<?= base_url('keuangan/save_laporan') ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="row m-3 w-75">
                                <label for="judul" class="col-sm-4 col-form-label">Judul</label>
                                <div class="col-sm-8 w-50">
                                    <input type="text" name="judul" class="form-control <?= $validation->hasError('judul') ? 'is-invalid' : '' ?>" id="judul" value="<?= old('judul') ?>" placeholder="Judul">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('judul') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="bulan" class="col-sm-4 col-form-label">Bulan</label>
                                <div class="col-sm-8 w-50">
                                    <select name="bulan" id="bulan" class="form-select <?= $validation->hasError('bulan') ? 'is-invalid' : '' ?>">
                                        <?php
                                        foreach ($month as $m) {
                                        ?>
                                            <option value="<?= $m['id'] ?>" <?= ($m['id'] == old('bulan') ? 'selected' : '') ?>><?= $m['name'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('bulan') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="tahun" class="col-sm-4 form-label">Tahun</label>
                                <div class="col-sm-8 input-group w-50">
                                    <select type="year" name="tahun" class="form-select <?= $validation->hasError('tahun') ? 'is-invalid' : '' ?>" id="tahun">
                                        <?php
                                        foreach ($year as $y) {
                                        ?>
                                            <option value="<?= $y ?>" <?= ($y == old('tahun') ? 'selected' : '') ?>><?= $y ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('tahun') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="file" class="col-sm-4 form-label">File</label>
                                <div class="col-sm-8 input-group w-50">
                                    <input type="file" name="file" id="file" class="form-control <?= $validation->hasError('file') ? 'is-invalid' : '' ?>" value="<?= old('file') ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('file') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row ms-4 mt-3 w-75">
                                <button type="submit" class="col-3 me-2 btn btn-sm btn-primary">Tambah</button>
                                <a href="<?= base_url('keuangan/laporan_keuangan') ?>" class="col-3 btn btn-secondary btn-sm">Batal</a>
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