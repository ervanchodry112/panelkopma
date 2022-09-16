<?php
echo $this->extend('dashboard/sidebar');

echo $this->section('main');
?>
<main>
    <div class="container p-0">
        <div class="row pt-3 mb-3">
            <div class="col">
                <h4 class="ps-3">Kode Referal</h4>
            </div>
            <hr>
        </div>
        <div class="row mx-2 mb-2">
            <div class="col d-flex justify-content-between">
                <!-- Search Fiela -->
                <div class="col d-flex align-items-center">
                    <a href="/psda/add_referal" class="btn btn-success btn-sm text-white d-flex align-items-center me-2 rounded-3">
                        <ion-icon name="add-outline" class="fs-6 align-middle"></ion-icon>
                        <span class="align-middle">Add</span>
                    </a>
                    <ion-icon name="search-outline" class="ms-auto"></ion-icon>
                    <form class="form w-25">
                        <input type="search" class="form-control d-flex rounded-pill ms-1" style="height: 28px;" placeholder="Search" aria-label="Search" id="fieldSearch" autocomplete="off">
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
                    Data berhasil dihapus!
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php
            session()->remove('pesan');
        }
        ?>
        <div class="container overflow-scroll">
            <table class="table table-striped table-responsive tabel-data fs-6" style="font-size: 12px;" id="tableData">
                <tr>
                    <th scope="col">Action</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Nomor Anggota</th>
                    <th scope="col">Kode Referal</th>
                    <!-- <th scope="col">Jumlah</th> -->
                </tr>
                <?php foreach ($referal as $d) { ?>
                    <tr id="<?= $d['npm'] ?>">
                        <td>
                            <form action="delete_referal/<?= $d['nomor_anggota'] ?>" method="POST">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" onclick="return confirm('Apakah anda yakin?')" class="btn btn-danger btn-sm">
                                    <ion-icon name="trash-outline"></ion-icon>
                                </button>
                            </form>
                        </td>
                        <td><?= $d['nama_lengkap'] ?></td>
                        <td><?= $d['nomor_anggota'] ?></td>
                        <td><?= $d['kode_referal'] ?></td>

                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</main>
<?= $this->endSection() ?>