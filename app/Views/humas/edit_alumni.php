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

                        <form action="<?= base_url('humas/save_edited_alumni') ?>" method="POST">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="id_alumni" value="<?= old('id_alumni') != null ? old('id_alumni') : $alumni->id_alumni ?>">
                            <div class="row m-3 w-75">
                                <label for="nama_alumni" class="col-sm-3 col-form-label">Nama Lengkap*</label>
                                <div class="col-sm-9">
                                    <input type="text" name="nama_alumni" class="form-control <?= ($validation->hasError('nama_alumni') ? 'is-invalid' : '') ?>" value="<?= old('nama_alumni') != null ? old('nama_alumni') : $alumni->nama_alumni ?>" id="nama_alumni" placeholder="Nama Lengkap" autofocus>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nama_alumni') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="alamat_alumni" class="col-sm-3 col-form-label">Alamat*</label>
                                <div class="col-sm-9">
                                    <textarea name="alamat_alumni" id="alamat_alumni" placeholder="Alamat" class="form-control <?= ($validation->hasError('alamat_alumni') ? 'is-invalid' : '') ?>"><?= old('alamat_alumni') != null ? old('alamat_alumni') : $alumni->alamat_alumni ?></textarea>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('alamat_alumni') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="email_alumni" class="col-sm-3 col-form-label">Email*</label>
                                <div class="col-sm-9">
                                    <input type="email" name="email_alumni" id="email_alumni" placeholder="email@example.com" class="form-control <?= ($validation->hasError('email_alumni') ? 'is-invalid' : '') ?>" value="<?= old('email_alumni') != null ? old('email_alumni') : $alumni->email_alumni ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('email_alumni') ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row m-3 w-75">
                                <label for="no_hp_alumni" class="col-sm-3 col-form-label">Nomor HP*</label>
                                <div class="col-sm-9">
                                    <input type="no_hp_alumni" name="no_hp_alumni" id="no_hp_alumni" placeholder="Nomor HP" class="form-control <?= ($validation->hasError('no_hp_alumni') ? 'is-invalid' : '') ?>" value="<?= old('no_hp_alumni') != null ? old('no_hp_alumni') : $alumni->no_hp_alumni ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('no_hp_alumni') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="tahun_lulus" class="col-sm-3 col-form-label">Tahun Lulus</label>
                                <div class="col-sm-9">
                                    <input type="number" name="tahun_lulus" id="tahun_lulus" placeholder="2000" class="form-control <?= ($validation->hasError('tahun_lulus') ? 'is-invalid' : '') ?>" value="<?= old('tahun_lulus') != null ? old('tahun_lulus') : $alumni->tahun_lulus ?>" min="1900" max="9999">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('tahun_lulus') ?>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $status = old('status_alumni') != null ? old('status_alumni') : $alumni->status_alumni;
                            $stts = [
                                'Alumni', 'Demisioner',
                            ];
                            ?>

                            <div class="row m-3 w-75">
                                <label for="status_alumni" class="col-sm-3 col-form-label">Status*</label>
                                <div class="col-sm-9">
                                    <select class="form-select <?= ($validation->hasError('status_alumni') ? 'is-invalid' : '') ?>" name="status_alumni" id="status_alumni">
                                        <option>-- Status --</option>
                                        <?php
                                        foreach ($stts as $s) {
                                        ?>
                                            <option value="<?= $s ?>" <?= $status == $s ? 'selected' : '' ?>><?= $s ?></option>

                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('status_alumni') ?>
                                    </div>
                                </div>
                            </div>


                            <div class="row ms-4 w-75">
                                <button type="submit" class="col-3 me-2 btn btn-sm btn-primary">Simpan</button>
                                <a href="<?= base_url('humas/alumni') ?>" class="col-3 btn btn-secondary btn-sm">Batal</a>
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