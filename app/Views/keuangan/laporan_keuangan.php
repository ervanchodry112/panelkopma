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

                        <div class="row mb-2">
                            <div class="col-3">
                                <div class="ms-3">
                                    <a href="<?= base_url('keuangan/add_laporan') ?>" class="btn btn-sm btn-primary w-75 justify-content-center d-flex align-items-center">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        Tambah Laporan
                                    </a>
                                </div>

                            </div>
                            <div class="col-4 ms-auto">
                                <form action="<?= base_url('keuangan/laporan_keuangan') ?>" method="post" class="d-flex align-items-center">
                                    <button type="submit" class="btn btn-sm btn-white">
                                        <i class="bi bi-search"></i>
                                    </button>
                                    <input type="search" name="search" id="search" class="form-control rounded-pill" placeholder="Search" autocomplete="FALSE">
                                </form>
                            </div>
                        </div>
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
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-striped table-responsive tabel-data text-center w-100" id="tableData">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Judul</th>
                                            <th scope="col">Bulan</th>
                                            <th scope="col">Tahun</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    if ($laporan == null) {
                                        echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
                                    } else {
                                        $i = 1;
                                        foreach ($laporan as $d) {
                                    ?>
                                            <tr>
                                                <th scope="row"><?= $i++ ?></th>
                                                <td>
                                                    <?= $d->judul ?>
                                                </td>
                                                <td>
                                                    <?= $d->bulan ?>
                                                </td>
                                                <td>
                                                    <?= $d->tahun ?>
                                                </td>

                                                <td>
                                                    <div class="row">
                                                        <div class="col-12 d-flex align-items-center justify-content-evenly">

                                                            <a href="<?= base_url('keuangan/view_laporan/' . $d->file) ?>" type="button" class="btn btn-primary btn-sm" target="_blank">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                            <form action="<?= base_url('keuangan/delete_laporan') ?>" method="post" enctype="multipart/form-data">
                                                                <input type="hidden" name="id" value="<?= $d->id ?>">
                                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus laporan?')">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</main>
<!-- End #main -->

<?= $this->endSection() ?>