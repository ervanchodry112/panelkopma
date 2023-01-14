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
                        <?php
                        if (session()->getFlashdata('success')) { ?>
                            <div class="row mx-1">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <span><?= session()->getFlashdata('success') ?></span>
                                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        <?php

                        } else if (session()->getFlashdata('error')) {
                        ?>
                            <div class="row mx-1">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <span><?= session()->getFlashdata('error') ?></span>
                                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <form action="<?= base_url('dashboard/submit_presensi') ?>" method="POST">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="id_kegiatan" id="id_kegiatan" value="<?= (old('id_kegiatan') ? old('id_kegiatan') : $id_kegiatan) ?>">
                            <div class="row m-3 w-75">
                                <label for="nomor_anggota" class="col-sm-3 col-form-label">Nomor Anggota</label>
                                <div class="col-sm-9">
                                    <select type="text" name="nomor_anggota" class="form-select text-uppercase <?= ($validation->hasError('nomor_anggota') ? 'is-invalid' : '') ?>" value="<?= old('nomor_anggota') ?>" id="_nomor_anggota">
                                        <?php
                                        foreach ($nomor as $row) {
                                            echo "<option value='" . $row['nomor_anggota'] . "'>" . $row['nomor_anggota'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nomor_anggota') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row ms-4 w-75">
                                <button type="submit" class="col-3 me-2 btn btn-sm btn-primary">Tambah</button>
                                <a href="<?= base_url('admin/akun_juko') ?>" class="col-3 btn btn-secondary btn-sm">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    $(document).ready(function() {
        $('#_nomor_anggota').select2({
                placeholder: "Pilih Nomor Anggota",
                theme: "bootstrap-5",
                // allowClear: true
            }

        );
    })
</script>
<!-- End #main -->

<?= $this->endSection() ?>