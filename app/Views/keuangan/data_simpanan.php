<?= $this->extend('dashboard/sidebar') ?>


<?= $this->section('main') ?>


<main id="main" class="main">
    <!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header mx-3 mt-3">
                        <h3><?= $title ?></h3>
                    </div>
                    <div class="card-body">
                        <!-- Buat Konten Disini -->
                        <div class="row mx-2 my-3">
                            <div class="col d-flex justify-content-between">
                                <!-- Search Field -->
                                <button class="btn btn-success rounded-3" style="font-size: .9em;" type="button" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                    <i class="bi bi-upload me-1"></i>
                                    XLSX
                                </button>

                                <!-- Search Fiela -->

                            </div>

                            <!-- Download Button -->
                            <div class="col justify-content-end d-flex">
                                <form class="form w-50 d-flex align-items-center me-3">
                                    <button type="submit" class="btn btn-sm">
                                        <ion-icon name="search-outline"></ion-icon>
                                    </button>
                                    <input name="search" type="search" class="form-control d-flex rounded-pill ms-1" style="height: 28px;" placeholder="Search" aria-label="Search" id="fieldSearch" autocomplete="off">
                                </form>
                                <a href="<?= base_url('keuangan/save_excel') ?>" class="btn btn-success btn-sm py-0 rounded-3 shadow-sm d-flex justify-content-center align-items-center" style="font-size: .8em;">
                                    <i class="bi bi-download me-2"></i>
                                    XLSX
                                </a>
                            </div>
                            <!-- Download Button -->

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
                        <?php
                        if (session()->getFlashdata('error')) {
                        ?>
                            <div class="row mx-2">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= session()->getFlashdata('error') ?>
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
                                    <th scope="col">#</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Nomor Anggota</th>
                                    <th scope="col">Simpanan Pokok</th>
                                    <th scope="col">Simpanan Wajib</th>
                                    <th scope="col">Total Simpanan</th>
                                    <th scope="col">Tagihan</th>
                                </thead>
                                <?php
                                $i = 1 + (25 * ($current_page - 1));
                                foreach ($simpanan as $d) {

                                ?>
                                    <tr>
                                        <th scope="row"><?= $i++ ?></th>
                                        <td>
                                            <form action="<?= base_url('keuangan/add_simpanan') ?>" method="post">
                                                <input type="hidden" name="nomor_anggota" value="<?= $d['nomor_anggota'] ?>">
                                                <button type="submit" class="btn btn-sm btn-warning">
                                                    <ion-icon name="add-outline"></ion-icon>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-start"><?= $d['nama_lengkap'] ?></td>
                                        <td><?= $d['nomor_anggota'] ?></td>
                                        <!-- <td class="text-start"></td> -->
                                        <td>Rp<?= number_format($d['simpanan_pokok'], 2) ?></td>
                                        <td>Rp<?= number_format($d['simpanan_wajib'], 2) ?></td>
                                        <td>Rp<?= number_format($d['simpanan_pokok'] + $d['simpanan_wajib'], 2) ?></td>
                                        <td>Rp<?= number_format($d['tagihan'], 2) ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                            <?= $pager->links('data_simpanan', 'custom_pagination') ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Upload Excel</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('keuangan/upload_data') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body mx-2">
                    <div class="row mb-3">
                        <div class="col-3 d-flex align-items-center">
                            <label for="file">File Excel</label>
                        </div>
                        <div class="col-9">
                            <input type="file" name="file" id="file" class="form-control">
                            <div class="text-muted" style="font-size: .8em;">*sesuaikan format file seperti template dibawah</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 d-flex align-items-center">
                            Template
                        </div>
                        <div class="col-9">
                            <a href="<?= base_url('assets/uploads/document/template/template_simpanan.xlsx') ?>" target="_blank" class="btn btn-primary btn-sm">
                                <i class="bi bi-download ms-1"></i>
                                Download
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End #main -->

<?= $this->endSection(); ?>