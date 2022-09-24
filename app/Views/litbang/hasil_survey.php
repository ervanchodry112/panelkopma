<?= $this->extend('dashboard/sidebar') ?>

<?= $this->section('main') ?>
<main>
    <div class="container p-0">
        <div class="row pt-3 mb-3">
            <div class="col">
                <h4 class="ps-3">Hasil Survey</h4>
            </div>
            <hr>
        </div>
        <div class="row mx-2 mb-2">
            <div class="col d-flex justify-content-between">
                <!-- Search Fiela -->
                <div class="col d-flex align-items-center">
                    <a href="/litbang/add_report" class="btn btn-success btn-sm text-white align-items-center me-2 rounded-3">
                        <span class="fs-6 align-middle">
                            <ion-icon name="add-outline"></ion-icon>
                        </span>
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
                    <?= session()->getFlashData('pesan') ?>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php
            session()->remove('pesan');
        }
        ?>
        <div class="container overflow-scroll">
            <table class="table table-striped table-responsive tabel-data fs-6" style="font-size: 12px;" id="tableData">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Action</th>
                        <th scope="col">Nama Survey</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Tangal Mulai</th>
                        <th scope="col">Tanggal Selesai</th>
                        <th scope="col">Responden</th>
                        <th scope="col">File</th>
                    </tr>
                </thead>
                <?php $i = 1;
                foreach ($laporan as $d) { ?>
                    <tr>
                        <th scope="row"><?= $i++ ?></td>
                        <td class="d-flex align-items-center">
                            <form action="/litbang/delete_report/<?= $d['id_laporan'] ?>" method="POST">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" onclick="return confirm('Apakah anda yakin?')" class="btn btn-danger btn-sm">
                                    <ion-icon name="trash-outline"></ion-icon>
                                </button>
                            </form>
                            <a href="/litbang/edit_report/<?= $d['id_laporan'] ?>" type="button" class="ms-1 btn btn-sm btn-warning">
                                <ion-icon name="create-outline"></ion-icon>
                            </a>
                        </td>
                        <td><?= $d['nama_survey'] ?></td>
                        <td><?= $d['deskripsi'] ?></td>
                        <td><?= $d['tanggal_mulai'] ?></td>
                        <td><?= $d['tanggal_selesai'] ?></td>
                        <td><?= $d['jumlah_responden'] ?></td>
                        <td class="d-flex align-items-center">
                            <a href="<?= "/litbang/view_report/" . $d['file'] ?>" class="btn btn-primary d-flex align-items-center">
                                <ion-icon name="cloud-download-outline"></ion-icon>
                                <span class="ms-1">Download</span>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</main>
<?= $this->endSection() ?>