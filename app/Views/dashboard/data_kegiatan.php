<?php
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
                    <a class="btn btn-success btn-sm text-white align-items-center me-2 rounded-3" href="add_kegiatan">
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


                

            </div>
        </div>

        <?php
        if (session()->getFlashdata('pesan')) { ?>
            <div class="row mx-2">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('pesan') ?>
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
                        <th scope="col">Nama Kegiatan</th>
                        <th scope="col">Lokasi</th>
                        <th scope="col">Tanggal</th>
                    </tr>
                </thead>
                <?php foreach ($kegiatan as $d) { ?>
                    <tr>
                        <td>
                            <a href="/dashboard/edit_kegiatan/<?= $d['id_kegiatan'] ?>" type="button" class="btn btn-success btn-sm">
                                <ion-icon class="col" name="create-outline"></ion-icon>
                            </a>
                            <a href="/dashboard/presensi/<?= $d['id_kegiatan'] ?>" type="button" class="btn btn-primary btn-sm">
                                <ion-icon class="col" name="clipboard-outline"></ion-icon>
                            </a>
                            <a href="kegiatan/<?= $d['id_kegiatan'] ?>" class="btn btn-sm btn-warning">
                                <ion-icon name="qr-code-outline"></ion-icon>
                                </button>
                        </td>
                        <td>
                            <?= $d['nama_kegiatan'] ?>
                        </td>
                        <td>
                            <?= $d['tempat_kegiatan'] ?>
                        </td>
                        <td>
                            <?= $d['tanggal_kegiatan'] ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>

        </div>
    </div>
</main>

<?= $this->endSection(); ?>