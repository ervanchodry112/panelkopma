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

                    <!-- Add Button -->
                    <a class="btn btn-success btn-sm text-white align-items-center me-2 rounded-3" href="tambah_data_simpanan.php">
                        <span class="fs-6 py-2 align-middle">
                            <ion-icon name="add-outline"></ion-icon>
                        </span>
                        <span class="align-middle">Add</span>
                    </a>
                    <!-- Add Button -->

                    <!-- Search Field -->
                    <ion-icon name="search-outline"></ion-icon>
                    <form class="form w-50">
                        <input type="search" class="form-control d-flex rounded-pill ms-1" style="height: 28px;" placeholder="Search" aria-label="Search" id="fieldSearch" autocomplete="off">
                    </form>
                    <!-- Search Fiela -->
                </div>


                <!-- Download Button -->
                <div class="col justify-content-end d-flex">
                    <a href="toExcel.php" class="btn btn-success btn-sm p-auto rounded-pill shadow-sm d-flex justify-content-center" style="width: 35%;">
                        <span class="me-1">
                            <ion-icon style="font-size: 16px;" name="download-outline"></ion-icon>
                        </span>
                        <span>
                            XLS
                        </span>
                    </a>
                </div>
                <!-- Download Button -->

            </div>
        </div>
        <div class="container overflow-scroll">
            <table class="table table-striped table-responsive tabel-data text-center w-100 fs-6" style="font-size: 12px;" id="tableData">
                <tr>
                    <th scope="col">Action</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Nomor Anggota</th>
                    <th scope="col">Simpanan Pokok</th>
                    <th scope="col">Simpanan Wajib</th>
                    <th scope="col">Total Simpanan</th>
                </tr>
                <?php foreach ($simpanan as $d) { ?>
                    <tr id="<?= $d['npm'] ?>">
                        <td>
                            <a href="edit_simpanan.php?npm=<?= $d['npm'] ?>&simwa=<?= $d['simpanan_wajib'] ?>&simpok=<?= $d['simpanan_pokok'] ?>" type="button" class="btn btn-sm btn-success">
                                <ion-icon name="create-outline"></ion-icon>
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
        </div>
    </div>
</main>

<?= $this->endSection(); ?>