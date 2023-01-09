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
                        <form action="<?= base_url('administrasi/save_edit_surat') ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="id" id="id" value="<?= (old('id') ? old('id') : $surat_masuk->id_surat) ?>">
                            <div class="row m-3 w-75">
                                <label for="no_surat" class="col-sm-3 col-form-label">Nomor Surat</label>
                                <div class="col-sm-9">
                                    <input type="text" name="no_surat" class="form-control <?= ($validation->hasError('no_surat') ? 'is-invalid' : '') ?>" value="<?= (old('no_surat') ? old('no_surat') : $surat_masuk->no_surat) ?>" id="no_surat" placeholder="Nomor Surat" autofocus>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('no_surat') ?>
                                    </div>
                                </div>

                            </div>
                            <div class="row m-3 w-75">
                                <label for="asal_surat" class="col-sm-3 col-form-label">Asal Surat</label>
                                <div class="col-sm-9">
                                    <input type="text" name="asal_surat" class="form-control <?= ($validation->hasError('asal_surat') ? 'is-invalid' : '') ?>" id=" asal_surat" placeholder="Asal Surat" value="<?= (old('asal_surat') ? old('asal_surat') : $surat_masuk->asal_surat) ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('asal_surat') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="isi_surat" class="col-sm-3 col-form-label">Isi</label>
                                <div class="col-sm-9">
                                    <input type="text" name="isi_surat" class="form-control <?= ($validation->hasError('isi_surat') ? 'is-invalid' : '') ?>" value="<?= (old('isi_surat') ? old('isi_surat') : $surat_masuk->isi_surat) ?>" id=" isi_surat" placeholder="Isi Surat">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('isi_surat') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="tgl_surat" class="col-sm-3 col-form-label">Tanggal Surat</label>
                                <div class="col-sm-9">
                                    <input type="date" name="tgl_surat" class="form-control <?= ($validation->hasError('tgl_surat') ? 'is-invalid' : '') ?>" value="<?= (old('tgl_surat') ? old('tgl_surat') : $surat_masuk->tgl_surat) ?>"" id=" tgl_surat" placeholder="Isi Surat">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('tgl_surat') ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row m-3 w-75">
                                <label for="kode" class="col-sm-3 col-form-label">Kode Surat</label>
                                <div class="col-sm-9">
                                    <select name="kode" class="form-select <?= ($validation->hasError('kode') ? 'is-invalid' : '') ?>" value="<?= (old('kode') ? old('kode') : $surat_masuk->kode) ?>"" id=" kode">
                                        <option selected><?= (old('kode') ? old('kode') : $surat_masuk->kode) ?></option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('kode') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="file" class="col-sm-3 col-form-label">File</label>
                                <div class="col-sm-9">
                                    <input type="file" name="file" id="file" class="form-control <?= ($validation->hasError('lpj') ? 'is-invalid' : '') ?>" value="<?= $surat_masuk->file ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('file') ?>
                                    </div>
                                    <div class="text-muted" style="font-size: .8em">*kosongkan jika file tidak perlu diganti</div>
                                </div>
                            </div>

                            <div class="row ms-4 w-75">
                                <button type="submit" class="col-3 me-2 btn btn-sm btn-primary">Simpan</button>
                                <a href="<?= base_url('administrasi/surat_masuk') ?>" class="col-3 btn btn-secondary btn-sm">Batal</a>
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