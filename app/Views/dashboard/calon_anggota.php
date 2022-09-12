<?php
echo $this->extend('dashboard/sidebar');


echo $this->section('main');
?>

<main>
    <div class="container ms-3 p-0">
        <div class="row pt-3 mb-3">
            <div class="col">
                <h4>Pendaftaran Anggota baru</h4>
            </div>
        </div>
        <div class="row mx-2 mb-2">
            <div class="col d-flex justify-content-between">
                <!-- Button Input Data From CSV -->
                <!-- <button type="button" class="btn btn-secondary btn-sm py-2 rounded-pill shadow-sm d-flex" data-bs-toggle="modal" data-bs-target="#modalUpload">
                              <span class="me-1">
                                   <ion-icon name="cloud-upload-outline"></ion-icon>
                              </span>
                              <span>
                                   Upload CSV
                              </span>
                         </button> -->
                <!-- Button Input Data Form CSV -->
                <!-- Search Fiela -->
                <div class="col d-flex align-items-center">
                    <ion-icon name="search-outline"></ion-icon>
                    <form class="form w-50">
                        <input type="search" class="form-control d-flex rounded-pill ms-1" style="height: 28px;" placeholder="Search" aria-label="Search" id="fieldSearch" autocomplete="off">
                    </form>
                </div>
                <!-- Search Field -->


                <!-- <div class="row"> -->


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
                <!-- </div> -->
            </div>
        </div>
        <div class="container overflow-scroll">
            <table class=" table table-striped table-responsive tabel-data" style="font-size: 12px;" id="tableData">
                <thead>
                    <tr>
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
                        <th scope="col">Alasan Masuk Kopma</th>
                        <th scope="col">Kode Referal</th>
                        <th scope="col">Berkas</th>
                    </tr>
                </thead>
                <?php foreach ($calon_anggota as $d) { ?>
                    <tr id="<?= $d['npm'] ?>">
                        <td>
                            <a href="hapus.php?npm=<?= $d['npm'] ?>&table=calon_anggota" type="button" onclick="return confirm('Apakah ingin menghapus') " class="btn btn-danger btn-sm">
                                <ion-icon name="trash-outline"></ion-icon>
                            </a>
                        </td>
                        <td><?= $d['npm'] ?></td>
                        <td><?= $d['nama_lengkap'] ?></td>
                        <td><?= $d['nama_panggilan'] ?></td>
                        <td><?= $d['nama_jurusan'] ?></td>
                        <td><?= $d['nama_fakultas'] ?></td>
                        <td><?= $d['nomor_hp'] ?></td>
                        <td><?= $d['email'] ?></td>
                        <td><?= $d['nama_platform'] ?></td>
                        <td><?= $d['domisili'] ?></td>
                        <td><?= $d['alasan'] ?></td>
                        <td><?= $d['kode_referal'] ?></td>
                        <td class="gy-2">
                            <a class="m-1 w-100 row btn btn-danger btn-sm" target="blank" href="../pendaftaran/include/upload/foto/<?= $d['foto'] ?>">
                                <div class="col bukti-btn">Foto</div>
                                <!-- <ion-icon name="document-text-outline"></ion-icon> -->
                            </a>
                            <a class="m-1 w-100 row btn btn-warning text-light btn-sm" target="blank" href="../pendaftaran/include/upload/ktm/<?= $d['ktm'] ?>">
                                <div class="col bukti-btn">KTM</div>
                                <!-- <ion-icon name="document-text-outline"></ion-icon> -->
                            </a>
                            <a class="m-1 w-100 row btn btn-success btn-sm" target="blank" href="../pendaftaran/include/upload/bukti-pembayaran/<?= $d['bukti_pembayaran'] ?>">
                                <div class="col bukti-btn">Pembayaran</div>
                            </a>
                        </td>
                        <!-- <td><a target="blank" href="../pendaftaran/include/upload/ktm/<?= $d['ktm'] ?>">
                                <ion-icon name="document-text-outline"></ion-icon>
                            </a></td>
                        <td>
                            <a target="blank" href="../pendaftaran/include/upload/bukti-pembayaran/<?= $d['bukti_pembayaran'] ?>">
                            </a>
                        </td> -->
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</main>

<?= $this->endSection(); ?>