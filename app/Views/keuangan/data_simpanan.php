<?php
$data = array();

// dd($simpanan);
?>

<?= $this->extend('dashboard/sidebar') ?>


<?= $this->section('main') ?>

<main>
    <div class="container p-0">
        <div class="row pt-3 mb-3">
            <div class="col">
                <h4 class="ps-3">Data Simpanan</h4>
            </div>
            <hr>
        </div>
        <div class="row mx-2 mb-2">
            <div class="col d-flex justify-content-between">


                <div class="col d-flex align-items-center">

                    <!-- Search Field -->
                    <ion-icon name="search-outline"></ion-icon>
                    <form class="form w-50">
                        <input type="search" class="form-control d-flex rounded-pill ms-1" style="height: 28px;" placeholder="Search" aria-label="Search" id="fieldSearch" autocomplete="off">
                    </form>
                    <!-- Search Fiela -->
                </div>


                <!-- Download Button -->
                <div class="col justify-content-end d-flex">
                    <!-- <a href="toExcel.php" class="btn btn-success btn-sm p-auto rounded-pill shadow-sm d-flex justify-content-center" style="width: 35%;">
                        <span class="me-1">
                            <ion-icon style="font-size: 16px;" name="download-outline"></ion-icon>
                        </span>
                        <span>
                            XLS
                        </span>
                    </a> -->
                </div>
                <!-- Download Button -->

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
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Action</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Nomor Anggota</th>
                    <th scope="col">Simpanan Pokok</th>
                    <th scope="col">Simpanan Wajib</th>
                    <th scope="col">Total Simpanan</th>
                </tr>
                <?php $i = 1 + (25 * ($current_page - 1));
                foreach ($simpanan as $d) { ?>
                    <tr>
                        <th scope="row"><?= $i++ ?></th>
                        <td>
                            <a href="<?= base_url('keuangan/add_simpanan/' . $d['npm']) ?>" type="button" class="btn btn-sm btn-warning">
                                <ion-icon name="add-outline"></ion-icon>
                            </a>
                        </td>
                        <td><?= $d['nama_lengkap'] ?></td>
                        <td><?= $d['nomor_anggota'] ?></td>
                        <!-- <td class="text-start"></td> -->
                        <td>Rp <?= $d['simpanan_pokok'] ?></td>
                        <td>Rp <?= $d['simpanan_wajib'] ?></td>
                        <td>Rp <?= $d['simpanan_pokok'] + $d['simpanan_wajib'] ?></td>
                    </tr>
                <?php } ?>
            </table>
            <?= $pager->links('data_simpanan', 'custom_pagination') ?>
        </div>
    </div>
</main>

<?= $this->endSection(); ?>