<?php
echo $this->extend('dashboard/sidebar');
echo $this->section('main');
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1><?= $title ?></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-4">
                <div class="card info-card sales-card">

                    <div class="card-body">
                        <h5 class="card-title">Jumlah Anggota</h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon border-info border border-2 text-info rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                                <div class="h1 fw-semibold">
                                    <?= $jumlah_anggota['jumlah'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card info-card sales-card">


                    <div class="card-body">
                        <h5 class="card-title">Total Simpanan</h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center border border-2 border-success text-success">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <div class="ps-3">
                                <div class="h3 fw-semibold">
                                    Rp <?= number_format($jumlah_simpanan['jumlah']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card info-card sales-card">


                    <div class="card-body">
                        <h5 class="card-title">Anggota Baru <span>| Tahun ini</span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center text-warning border border-warning border-2">
                                <i class="bi bi-person-plus"></i>
                            </div>
                            <div class="ps-3">
                                <div class="h1 fw-semibold">
                                    <?= $jumlah_baru['jumlah'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header mx-2 mt-2">
                            Kegiatan Selesai
                        </div>
                        <div class="card-body my-3">
                            <table class="table table-white">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Kegiatan</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Tempat</th>
                                        <th scope="col">Peserta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($kegiatan_selesai as $k) {
                                        if ($i > 5) break;
                                    ?>
                                        <tr>
                                            <th scope="row"><?= $i++ ?></th>
                                            <td><?= $k['nama_kegiatan'] ?></td>
                                            <td><?= date_format(date_create($k['tanggal_kegiatan']), 'd M Y')  ?></td>
                                            <td><?= $k['tempat_kegiatan'] ?></td>
                                            <td><?= $k['peserta'] ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-header mx-2 mt-2">
                            Kegiatan Terdekat
                        </div>
                        <div class="card-body my-3">
                            <table class="table table-white">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Kegiatan</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Tempat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($kegiatan as $k) {
                                        if ($i > 5) break;
                                    ?>
                                        <tr>
                                            <th scope="row"><?= $i++ ?></th>
                                            <td><?= $k['nama_kegiatan'] ?></td>
                                            <td><?= date_format(date_create($k['tanggal_kegiatan']), 'd M Y')  ?></td>
                                            <td><?= $k['tempat_kegiatan'] ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>


<?= $this->endSection(); ?>