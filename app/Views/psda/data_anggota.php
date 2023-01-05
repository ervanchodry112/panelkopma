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
                                    <a class="btn btn-success btn-sm text-white align-items-center me-2 rounded-3" href="<?= base_url('psda/add_anggota') ?>">
                                        <span class="fs-6 align-middle">
                                            <ion-icon name="add-outline"></ion-icon>
                                        </span>
                                        <span class="align-middle">Add</span>
                                    </a>
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
                            <table class="table table-striped table-responsive" style="font-size: .8em;" id="tableData">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">NPM</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Nomor Anggota</th>
                                        <th scope="col">Jurusan</th>
                                        <th scope="col">Nomor WA</th>
                                        <th scope="col">Email</th>
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
                                        <td><?= $d['nama_jurusan'] ?></td>
                                        <td><?= $d['nomor_hp'] ?></td>
                                        <td><?= $d['email'] ?></td>
                                        <td class="d-flex">
                                            <form action="<?= base_url('psda/delete_anggota') ?>" method="POST">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" name="nomor_anggota" value="<?= $d['nomor_anggota'] ?>">
                                                <button type="submit" onclick="return confirm('Apakah anda yakin?')" class="btn btn-danger btn-sm">
                                                    <ion-icon name="trash-outline"></ion-icon>
                                                </button>
                                            </form>
                                            <a href="<?= base_url('psda/edit_anggota/' . $d['npm']) ?>" type="button" class="ms-1 btn btn-sm btn-warning">
                                                <ion-icon name="create-outline"></ion-icon>
                                            </a>
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
<!-- End #main -->

<?= $this->endSection() ?>