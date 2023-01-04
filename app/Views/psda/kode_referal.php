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
                            <div class="col d-flex justify-content-between align-items-center">
                                <!-- Search Fiela -->

                                <a href="<?= base_url('psda/add_referal') ?>" class="btn btn-success btn-sm text-white d-flex align-items-center me-2 rounded-3">
                                    <ion-icon name="add-outline" class="fs-6 align-middle"></ion-icon>
                                    <span class="align-middle">Add</span>
                                </a>

                                <form action="<?= base_url('psda/kode_referal') ?>" method="POST" class="form w-25 col-10 d-flex align-items-center">
                                    <div class="input-group mb-3">
                                        <input type="search" class="form-control" placeholder="Search" name="search">
                                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                                            <ion-icon name="search-outline" class="ms-auto"></ion-icon>
                                        </button>
                                    </div>
                                </form>


                                <!-- Search Field -->

                                <!-- </div> -->
                            </div>
                        </div>
                        <?php
                        if (session()->getFlashdata('pesan')) {
                        ?>
                            <div class="row mx-2">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    Data berhasil dihapus!
                                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        <?php
                            session()->remove('pesan');
                        }
                        ?>
                        <div class="container overflow-scroll">
                            <table class="table table-striped table-responsive tabel-data fs-6 text-center" style="font-size: 12px;" id="tableData">
                                <thead>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Nomor Anggota</th>
                                    <th scope="col">Kode Referal</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Action</th>
                                    <!-- <th scope="col">Jumlah</th> -->
                                </thead>
                                <tbody>
                                    <?php
                                    if ($referal == null) {
                                    ?>
                                        <tr>
                                            <td colspan='6'>Data tidak ditemukan</td>
                                        </tr>
                                        <?php
                                    } else {
                                        $i = 1;
                                        foreach ($referal as $d) { ?>
                                            <tr>
                                                <th scope="row"><?= $i++ ?></th>
                                                <td><?= $d['nama_lengkap'] ?></td>
                                                <td><?= $d['nomor_anggota'] ?></td>
                                                <td><?= $d['kode_referal'] ?></td>
                                                <td><?= $d['jumlah'] ?></td>
                                                <td>
                                                    <form action="<?= base_url('delete_referal/' . $d['nomor_anggota']) ?>" method="POST">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" onclick="return confirm('Apakah anda yakin?')" class="btn btn-danger btn-sm">
                                                            <ion-icon name="trash-outline"></ion-icon>
                                                        </button>
                                                    </form>
                                                </td>

                                            </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- End #main -->
<?= $this->endSection() ?>