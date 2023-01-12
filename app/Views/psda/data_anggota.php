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
                    <div class="card-body my-3">
                        <!-- Buat Konten Disini -->
                        <div class="row mx-2 mb-2">
                            <div class="col d-flex justify-content-between">
                                <!-- Search Fiela -->
                                <div class="col d-flex align-items-center">
                                    <div class="btn-group">
                                        <a class="btn btn-success btn-sm text-white d-flex align-items-center" role="group" href="<?= base_url('psda/add_anggota') ?>">
                                            <i class="bi bi-plus bold" style="font-size: 1.4em;"></i>
                                        </a>
                                        <button class="btn btn-success border-start" type="button" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                            <i class="bi bi-upload me-1"></i>
                                            XLSX
                                        </button>
                                    </div>
                                    <form class="form w-25 ms-auto d-flex align-items-center" method="POST" action="<?= base_url('psda/data_anggota') ?>">
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
                            <table class="table align-middle table-striped table-responsive" style="font-size: .8em;" id="tableData">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">NPM</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Nomor Anggota</th>
                                        <th scope="col">Jenis Kelamin</th>
                                        <th scope="col">Jurusan</th>
                                        <th scope="col">Fakultas</th>
                                        <th scope="col">Nomor WA</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Keanggotaan</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <?php $i = 1 + (25 * ($currentPage - 1));
                                foreach ($anggota as $d) { ?>
                                    <tr>
                                        <th scope="row"><?= $i++ ?></th>
                                        <td><?= $d['npm'] ?></td>
                                        <td><?= $d['nama_lengkap'] ?></td>
                                        <td><?= $d['nomor_anggota'] ?></td>
                                        <td><?= $d['jenis_kelamin'] ?></td>
                                        <td><?= $d['jurusan'] ?></td>
                                        <td><?= $d['fakultas'] ?></td>
                                        <td><?= $d['nomor_hp'] ?></td>
                                        <td><?= $d['email'] ?></td>
                                        <td><?= $d['keanggotaan'] ?></td>
                                        <td>
                                            <div class="row">
                                                <div class="col-12 d-flex align-items-center">
                                                    <form action="<?= base_url('psda/delete_anggota') ?>" method="POST">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="nomor_anggota" value="<?= $d['nomor_anggota'] ?>">
                                                        <button type="submit" onclick="return confirm('Apakah anda yakin?')" class="btn btn-danger btn-sm">
                                                            <ion-icon name="trash-outline"></ion-icon>
                                                        </button>
                                                    </form>
                                                    <a href="<?= base_url('psda/edit_anggota/' . $d['npm']) ?>" type="button" class="ms-2 btn btn-sm btn-warning">
                                                        <ion-icon name="create-outline"></ion-icon>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                            <?= $pager->links('data_anggota', 'custom_pagination') ?>
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
                <h1 class="modal-title fs-5">Upload CSV</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('psda/upload_anggota') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body mx-2">
                    <div class="row mb-3">
                        <div class="col-3 d-flex align-items-center">
                            <label for="csv">File Excel</label>
                        </div>
                        <div class="col-9">
                            <input type="file" name="csv" id="csv" class="form-control">
                            <div class="text-muted" style="font-size: .8em;">*sesuaikan format file seperti template dibawah</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 d-flex align-items-center">
                            Template
                        </div>
                        <div class="col-9">
                            <a href="<?= base_url('assets/template/template_anggota.csv') ?>" target="_blank" class="btn btn-primary btn-sm">
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

<?= $this->endSection() ?>