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
                                        <a class="btn btn-success btn-sm text-white d-flex align-items-center" role="group" href="<?= base_url('humas/add_alumni') ?>">
                                            <i class="bi bi-plus bold" style="font-size: 1.4em;"></i>
                                        </a>
                                        <button class="btn btn-success border-start" type="button" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                            <i class="bi bi-upload me-1"></i>
                                            XLSX
                                        </button>
                                    </div>
                                    <form class="form w-25 ms-auto d-flex align-items-center" method="POST" action="<?= base_url('humas/alumni') ?>">
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
                        if (session()->getFlashdata('success')) {
                        ?>
                            <div class="row mx-2">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?= session()->getFlashData('success') ?>
                                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        <?php
                            session()->remove('success');
                        }

                        if (session()->getFlashdata('error')) {
                        ?>
                            <div class="row mx-2">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= session()->getFlashData('error') ?>
                                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        <?php
                            session()->remove('error');
                        }
                        ?>
                        <div class="container overflow-scroll">
                            <table class="table align-middle table-striped table-responsive" style="font-size: .8em;" id="tableData">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Nomor WA</th>
                                        <th scope="col">Tahun Lulus</th>
                                        <th scope="col">Status Alumni</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <?php
                                if ($alumni == null) {
                                    echo "<tr><td colspan='8' class='text-center'>Data tidak ditemukan</td></tr>";
                                } else {
                                    $i = 1 + (50 * ($currentPage - 1));
                                    foreach ($alumni as $d) {
                                ?>
                                        <tr>
                                            <th scope="row"><?= $i++ ?></th>
                                            <td><?= $d->nama_alumni ?></td>
                                            <td><?= $d->alamat_alumni ?></td>
                                            <td><?= $d->email_alumni ?></td>
                                            <td><?= $d->no_hp_alumni ?></td>
                                            <td><?= $d->tahun_lulus ?></td>
                                            <td><?= $d->status_alumni ?></td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-12 d-flex align-items-center">
                                                        <form action="<?= base_url('humas/delete_alumni') ?>" method="POST">
                                                            <?= csrf_field(); ?>
                                                            <input type="hidden" name="slug" value="<?= $d->slug_alumni ?>">
                                                            <button type="submit" onclick="return confirm('Apakah anda yakin?')" class="btn btn-danger btn-sm">
                                                                <ion-icon name="trash-outline"></ion-icon>
                                                            </button>
                                                        </form>
                                                        <a href="<?= base_url('humas/edit_alumni/' . $d->slug_alumni) ?>" class="ms-2 btn btn-sm btn-warning">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <!-- <form action="<?php // base_url('humas/edit_alumni') 
                                                                            ?>" method="post">
                                                        <input type="hidden" name="slug" value="<?= $d->slug_alumni ?>">
                                                        <button type="submit" class="ms-2 btn btn-sm btn-warning">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                    </form> -->

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </table>
                            <?= $pager->links('alumni', 'custom_pagination') ?>
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
                <h1 class="modal-title fs-5">Upload XLSX</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('humas/upload_alumni') ?>" method="post" enctype="multipart/form-data">
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
                            <a href="<?= base_url('assets/uploads/document/template/template_upload_alumni.xlsx') ?>" target="_blank" class="btn btn-primary btn-sm">
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