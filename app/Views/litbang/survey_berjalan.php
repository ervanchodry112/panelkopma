<?php

echo $this->extend('dashboard/sidebar');
echo $this->section('main');
?>

<main id="main" class="main">
    <!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-12">
                <div class="card w-100">
                    <div class="card-header mx-3 mt-3">
                        <h3><?= $title ?></h3>

                    </div>

                    <div class="card-body my-3">
                        <!-- Buat Konten Disini -->
                        <div class="row mx-2 mb-2">
                            <div class="col d-flex justify-content-between">
                                <!-- Search Fiela -->
                                <div class="col d-flex align-items-center">
                                    <a class="btn btn-success btn-sm text-white align-items-center me-2 rounded-3" href="<?= base_url('litbang/tambah_survey') ?>">
                                        <ion-icon name="add-outline"></ion-icon>
                                        Tambah
                                    </a>
                                    <form class="form w-25 ms-auto d-flex align-items-center" method="POST" action="<?= base_url('litbang/survey_berjalan') ?>">
                                        <button type="submit" class="btn btn-white">
                                            <ion-icon name="search-outline"></ion-icon>
                                        </button>
                                        <input name="search" type="search" class="form-control d-flex rounded-pill ms-1" style="height: 28px;" placeholder="Search" aria-label="Search" id="fieldSearch" autocomplete="off">
                                    </form>
                                </div>
                                <!-- Search Field -->

                                <!-- </div> -->
                            </div>
                        </div>
                        <?php
                        if (session()->getFlashdata('error')) {
                        ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                        } else if (session()->getFlashdata('success')) {
                        ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                        }
                        ?>
                        <table class="table table-responsive table-striped rounded">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Survey</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Link</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($survey == null) {
                                ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data</td>
                                    </tr>
                                <?php
                                } else {


                                    $i = 1;
                                ?>
                                    <?php
                                    foreach ($survey as $s) :
                                        $status = $s->tgl_selesai <= date('Y-m-d');
                                    ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $s->nama_survey; ?></td>
                                            <td><?= $s->deskripsi; ?></td>
                                            <td><?= date_format(date_create($s->tgl_mulai), 'd F Y') ?></td>
                                            <td><?= date_format(date_create($s->tgl_selesai), 'd F Y') ?></td>
                                            <td><?= $s->link; ?></td>
                                            <td>
                                                <div style="height: min-content;" class="badge bg-<?= ($status ? 'success' : 'danger') ?>">
                                                    <strong><?= ($status ? 'Selesai' : 'Berjalan') ?></strong>
                                                </div>
                                            </td>
                                            <td>
                                                <form action="<?= base_url('/litbang/edit_survey') ?>" method="post" class="d-inline">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" value="<?= $s->id ?>" name="id">
                                                    <button type="submit" class="btn btn-warning btn-sm">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                </form>
                                                <form action="<?= base_url('/litbang/finish_survey') ?>" method="post" class="d-inline">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="id" value="<?= $s->id ?>">
                                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Apakah anda yakin?');">
                                                        <i class="bi bi-check"></i>
                                                    </button>
                                                </form>
                                                <form action="<?= base_url('/litbang/delete_survey?id=' . $s->id) ?>" method="post" class="d-inline">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin?');">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                <?php
                                    endforeach;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- End #main -->

<?= $this->endSection() ?>