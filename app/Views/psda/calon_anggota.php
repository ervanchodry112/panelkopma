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
                                <!-- Button Input Data From CSV -->

                                <!-- Search Fiela -->
                                <div class="col ">
                                    <form class="form w-50 d-flex align-items-center" action="<?= base_url('psda/calon_anggota') ?>">
                                        <button type="submit" class="btn btn-white btn-sm">
                                            <ion-icon name="search-outline"></ion-icon>
                                        </button>
                                        <input name="search" type="search" class="form-control d-flex rounded-pill ms-1" style="height: 28px;" placeholder="Search" aria-label="Search" id="fieldSearch" autocomplete="off">
                                    </form>
                                </div>
                                <!-- Search Field -->


                                <!-- <div class="row"> -->


                                <!-- Download Button -->
                                <div class="col justify-content-end d-flex">
                                    <a href="<?= base_url('psda/download_calon') ?>" class="btn btn-success btn-sm p-auto rounded-pill shadow-sm d-flex justify-content-center" style="width: 35%;">
                                        <span class="me-1">
                                            <ion-icon style="font-size: 16px;" name="download-outline"></ion-icon>
                                        </span>
                                        <span>
                                            XLS
                                        </span>
                                    </a>
                                </div>
                                <!-- Download Button -->
                                <!-- </div> -->
                            </div>
                        </div>
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
                            session()->remove('error');
                        }
                        ?>
                        <?php
                        if (session()->getFlashdata('success')) {
                        ?>
                            <div class="row mx-2">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?= session()->getFlashdata('success') ?>
                                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        <?php
                            session()->remove('success');
                        }
                        ?>
                        <div class="container overflow-scroll">
                            <table class=" table table-striped table-responsive table-hover table-sm" style="font-size: 12px;" id="tableData">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Action</th>
                                        <th scope="col">NPM</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Panggilan</th>
                                        <th scope="col">Jurusan</th>
                                        <th scope="col">Fakultas</th>
                                        <th scope="col">Nomor WA</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Asal Informasi</th>
                                        <th scope="col">Domisili</th>
                                        <th scope="col">Tempat Lahir</th>
                                        <th scope="col">Tanggal Lahir</th>
                                        <th scope="col">Alasan Masuk Kopma</th>
                                        <th scope="col">Kode Referal</th>
                                        <th scope="col">Berkas</th>
                                    </tr>
                                </thead>
                                <?php $i = 1 + (25 * ($current_page - 1));
                                foreach ($calon_anggota as $d) { ?>
                                    <tr id="<?= $d['npm'] ?>">
                                        <th scope="row"><?= $i++ ?></th>
                                        <td>
                                            <form action="<?= base_url('psda/delete_calon/' . $d['npm']) ?>" method="POST">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" onclick="return confirm('Apakah anda yakin?')" class="btn btn-danger btn-sm">
                                                    <ion-icon name="trash-outline"></ion-icon>
                                                </button>
                                            </form>
                                        </td>
                                        <td><?= $d['npm'] ?></td>
                                        <td><?= $d['nama_lengkap'] ?></td>
                                        <td><?= $d['nama_panggilan'] ?></td>
                                        <td><?= $d['jurusan'] ?></td>
                                        <td><?= $d['fakultas'] ?></td>
                                        <td><?= $d['nomor_hp'] ?></td>
                                        <td><?= $d['email'] ?></td>
                                        <td><?= $d['asal_informasi'] ?></td>
                                        <td><?= $d['domisili'] ?></td>
                                        <td><?= $d['tempat_lahir'] ?></td>
                                        <td><?= $d['tanggal_lahir'] ?></td>
                                        <td><?= $d['alasan'] ?></td>
                                        <td><?= $d['kode_referal'] ?></td>
                                        <td class="gy-2">
                                            <a href="<?= base_url('assets/uploads/document/regist/foto/' . $d['foto']) ?>" class="m-1 w-100 row btn btn-danger btn-sm" target="_blank">
                                                <div class="col bukti-btn">Foto</div>
                                            </a>
                                            <a href="<?= base_url('assets/uploads/document/regist/ktm/' . $d['ktm']) ?>" class="m-1 w-100 row btn btn-warning btn-sm" target="_blank">
                                                <div class="col bukti-btn">KTM</div>
                                            </a>
                                            <a href="<?= base_url('assets/uploads/document/regist/bukti_pembayaran/' . $d['bukti_pembayaran']) ?>" class="m-1 w-100 row btn btn-success btn-sm" target="_blank">
                                                <div class="col bukti-btn">Bukti Pembayaran</div>
                                            </a>

                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                            <?= $pager->links('calon_anggota', 'custom_pagination') ?>
                        </div>
                        <?php
                        if (user()->username == 'admin') {
                        ?>
                            <div class="row mt-4">
                                <div class="col-12 d-flex justify-content-center">
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal">
                                        <i class="bi bi-arrow-clockwise"></i>
                                        Reset Data Calon Anggota
                                    </button>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Konfirmasi Reset Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('psda/reset_calon') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body mx-2">
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-danger text-center" role="alert">
                                <strong>Perhatian!</strong><br>
                                Ini akan menghapus seluruh data <strong>Calon Anggota</strong>!.
                            </div>
                        </div>
                    </div>
                    <?php
                    $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                    $random_word = substr(str_shuffle($letters), 0, 8);
                    ?>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            <div class="h4 border border-2 p-3 rounded"><?= $random_word ?></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 text-center">
                            Silakan ketikan kembali kata diatas untuk mengkonfirmasi penghapusan data!
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            <?= csrf_field() ?>
                            <input type="text" name="confirm" id="confirm" class="form-control text-center" placeholder="____________________">
                            <input type="hidden" name="random" value="<?= $random_word ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin melakukan reset data calon anggota?')">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End #main -->

<?= $this->endSection(); ?>