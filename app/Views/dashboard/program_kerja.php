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
                                <!-- Search Fiela -->
                                <div class="row d-flex align-items-center">
                                    <div class="col-3">
                                        <a href="<?= base_url('dashboard/add_progja') ?>" class="d-flex align-items-center btn btn-success btn-sm text-white rounded-3">
                                            <ion-icon name="add-outline"></ion-icon>
                                            <span class="d-flex align-self-center ms-1">Add</span>
                                        </a>
                                    </div>
                                    <div class="col-9">
                                        <form class="form w-100 d-flex align-items-center" method="POST" action="<?= base_url('dashboard/program_kerja') ?>">
                                            <button type="submit" class="btn btn-white">
                                                <ion-icon name="search-outline"></ion-icon>
                                            </button>
                                            <input name="search" type="search" class="form-control d-flex rounded-pill ms-1" style="height: 28px;" placeholder="Search" aria-label="Search" id="fieldSearch" autocomplete="off">
                                        </form>
                                    </div>
                                </div>
                                <!-- Search Field -->
                                <form action="<?= base_url('dashboard/program_kerja') ?>" method="post" class="d-flex align-items-center">
                                    <select name="tahun" id="tahun" class="form-select form-sm ms-auto">
                                        <option value="">Pilih Tahun</option>
                                        <?php
                                        foreach ($tahun as $t) {
                                        ?>
                                            <option value="<?= $t ?>" <?= ($t == $tahun_selected) ? 'selected' : '' ?>><?= $t ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <button type="submit" class="btn btn-success btn-sm ms-3">GO</button>
                                </form>
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
                        <table class="table text-center table-striped table-responsive fs-6 align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Program</th>
                                    <th scope="col">Deskripsi</th>
                                    <th scope="col">Pelaksanaan</th>
                                    <th scope="col">Bidang</th>
                                    <th scope="col">Tahun Program</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($progja == null) {
                                    echo "<tr><td colspan='7' class='text-center'>Tidak ada data</td></tr>";
                                } else {
                                    $i = 1;
                                    foreach ($progja as $p) {
                                ?>
                                        <tr>
                                            <th scope="row"><?= $i++ ?></th>
                                            <td><?= $p->nama_program ?></td>
                                            <td><?= $p->deskripsi ?></td>
                                            <td><?= date_format(date_create($p->rencana_pelaksanaan), 'd F Y') ?></td>
                                            <td><?= ucfirst($p->username) ?></td>
                                            <td><?= $p->tahun ?></td>
                                            <td>
                                                <div class="badge bg-<?= ($p->status == 'Sudah Terlaksana') ? 'success' : ($p->status == 'Belum Terlaksana' ? 'warning' : 'danger') ?>">

                                                    <?= ucfirst($p->status) ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-12 text-center">

                                                        <form action="<?= base_url('dashboard/edit_progja') ?>" method="post">
                                                            <input type="hidden" name="id" value="<?= $p->id ?>">
                                                            <button class="btn btn-sm btn-warning my-2">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                        </form>
                                                        <?php
                                                        if ($p->status == 'Sudah Terlaksana' && $p->lpj != null && $p->proposal != null) {
                                                        ?>
                                                            <a href="<?= base_url('dashboard/view_proposal/' . $p->proposal) ?>" class="btn btn-sm btn-primary d-flex align-items-center justify-content-center my-2" target="_blank">
                                                                <i class="bi bi-eye me-2"></i>
                                                                Proposal
                                                            </a>
                                                            <a href="<?= base_url('dashboard/view_lpj/' . $p->lpj) ?>" class="btn btn-sm btn-primary d-flex align-items-center justify-content-center my-2" target="_blank">
                                                                <i class="bi bi-eye me-2"></i>
                                                                LPJ
                                                            </a>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <form action="<?= base_url('dashboard/upload_lpj') ?>" method="post">
                                                                <input type="hidden" name="id" value="<?= $p->id ?>">
                                                                <button class="btn btn-sm btn-primary my-2">
                                                                    <i class="bi bi-upload"></i>
                                                                </button>
                                                            </form>

                                                        <?php
                                                        }
                                                        ?>
                                                        <form action="<?= base_url('dashboard/delete_progja') ?>" method="post">
                                                            <input type="hidden" name="id" value="<?= $p->id ?>">
                                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- End #main -->

<?= $this->endSection() ?>