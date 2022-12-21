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

                        <div class="row mx-2 mb-2">
                            <div class="col d-flex justify-content-between">
                                <div class="col d-flex align-items-center">

                                    <!-- Search Field -->
                                    <ion-icon name="search-outline" class="ms-auto"></ion-icon>
                                    <form class="form w-25">
                                        <input type="search" class="form-control d-flex rounded-pill ms-1" style="height: 28px;" placeholder="Search" aria-label="Search" id="fieldSearch" autocomplete="off">
                                    </form>
                                    <!-- Search Field -->
                                </div>
                            </div>
                        </div>
                        <?php
                        if (session()->getFlashdata('pesan')) {
                        ?>
                            <div class="row mx-2">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?= session()->getFlashData('pesan') ?>
                                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        <?php
                            session()->remove('pesan');
                        }
                        ?>
                        <div class="container overflow-scroll">
                            <table class="table table-striped table-responsive tabel-data text-center w-100 fs-6" style="font-size: 12px;" id="tableData">
                                <thead>
                                    <tr>
                                        <th scope="col">Action</th>
                                        <th scope="col">NPM</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Nomor Anggota</th>
                                        <th scope="col">Poin</th>
                                    </tr>
                                </thead>
                                <?php foreach ($data as $d) { ?>
                                    <tr id="<?= $d['npm'] ?>">
                                        <td>
                                            <a href="<?= base_url('psda/add_value/' . $d['nomor_anggota']) ?>" type="button" class="btn btn-sm btn-warning">
                                                <ion-icon name="add-outline"></ion-icon>
                                        </td>
                                        <td><?= $d['npm'] ?></td>
                                        <td><?= $d['nama_lengkap'] ?></td>
                                        <td><?= $d['nomor_anggota'] ?></td>
                                        <td><?= $d['poin'] + (int) (($d['simpanan_wajib'] / 10000) * 3) ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- End #main -->

<?= $this->endSection(); ?>