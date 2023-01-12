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
                        <form action="<?= base_url('usaha/save_produk') ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="row m-3 w-75">
                                <label for="nama_produk" class="col-sm-3 col-form-label">Nama Produk</label>
                                <div class="col-sm-9">
                                    <input type="text" name="nama_produk" class="form-control <?= ($validation->hasError('nama_produk') ? 'is-invalid' : '') ?>" value="<?= old('nama_produk') ?>"" id=" nama_produk" placeholder="Nama Produk" autofocus>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nama_produk') ?>
                                    </div>
                                </div>

                            </div>
                            <div class="row m-3 w-75">
                                <label for="harga_produk" class="col-sm-3 col-form-label">Harga Produk</label>
                                <div class="col-sm-8 input-group w-75">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="harga_produk" class="form-control <?= ($validation->hasError('harga_produk') ? 'is-invalid' : '') ?>" id=" harga_produk" placeholder="Harga Produk" value="<?= old('harga_produk') ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('harga_produk') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="file" class="col-sm-3 col-form-label">Gambar</label>
                                <div class="col-sm-9">
                                    <input type="file" name="file" id="file" class="form-control <?= ($validation->hasError('lpj') ? 'is-invalid' : '') ?>" value="<?= old('file') ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('file') ?>
                                    </div>
                                    <div class="text-muted" style="font-size: .8em;">*format: png, jpg, jpeg</div>
                                </div>
                            </div>

                            <div class="row ms-4 w-75">
                                <button type="submit" class="col-3 me-2 btn btn-sm btn-primary">Tambah</button>
                                <a href="<?= base_url('usaha/produk') ?>" class="col-3 btn btn-secondary btn-sm">Batal</a>
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