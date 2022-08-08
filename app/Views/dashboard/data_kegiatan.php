<?php
$data = array();
echo $this->extend('dashboard/sidebar');
echo $this->section('main');
?>

<main>
    <div class="container p-0">
        <div class="row pt-3 mb-3">
            <div class="col">
                <h4 class="ps-3">Data Kegiatan</h4>
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
                    <th scope="col">Nama Kegiatan</th>
                    <th scope="col">Lokasi</th>
                    <th scope="col">Tanggal</th>
                </tr>
                <!-- <?php //foreach ($data as $d) { 
                        ?> -->
                <tr>
                    <td>
                        <a href="" type="button" class="btn btn-success btn-sm">
                            <span class="row text-center">
                                <ion-icon class="col" name="create-outline" size="small"></ion-icon>
                            </span>
                            <span class="row">
                                <div class="col" style="font-size: 12px;">
                                    Ubah
                                </div>
                            </span>
                        </a>
                        <a href="<?= base_url('dashboard/presensi') ?>" type="button" class="btn btn-primary btn-sm">
                            <span class="row">
                                <ion-icon class="col" size="small" name="clipboard-outline"></ion-icon>
                            </span>
                            <span class="row">
                                <div class="col" style="font-size: 12px;">
                                    Presensi
                                </div>
                            </span>
                        </a>
                    </td>

                </tr>
                <?php //} 
                ?>
            </table>
        </div>
    </div>
</main>

<?= $this->endSection(); ?>