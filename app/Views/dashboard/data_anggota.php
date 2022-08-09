<?= $this->extend('dashboard/sidebar') ?>

<?= $this->section('main') ?>
<main>
    <div class="container p-0">
        <div class="row pt-3 mb-3">
            <div class="col">
                <h4 class="ps-3">Data Anggota</h4>
            </div>
            <hr>
        </div>
        <div class="row mx-2 mb-2">
            <div class="col d-flex justify-content-between">
                <!-- Search Fiela -->
                <div class="col d-flex align-items-center">
                    <a class="btn btn-success btn-sm text-white align-items-center me-2 rounded-3" href="tambah_data.php">
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
        <div class="container overflow-scroll">
            <table class="table table-striped table-responsive tabel-data fs-6" style="font-size: 12px;" id="tableData">
                <tr>
                    <th scope="col">Action</th>
                    <th scope="col">NPM</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Nomor Anggota</th>
                    <th scope="col">Jurusan</th>
                    <th scope="col">Nomor WA</th>
                    <th scope="col">Email</th>
                </tr>
                <?php foreach ($anggota as $d) { ?>
                    <tr id="<?= $d['npm'] ?>">
                        <td>
                            <a href="hapus.php?npm=<?= $d['npm'] ?>" type="button" onclick="return confirm('Apakah ingin menghapus') " class="btn btn-danger btn-sm">
                                <ion-icon name="trash-outline"></ion-icon>
                            </a>
                        </td>
                        <td><?= $d['npm'] ?></td>
                        <td><?= $d['nama_lengkap'] ?></td>
                        <td><?= $d['nomor_anggota'] ?></td>
                        <td><?= $d['id_jurusan'] ?></td>
                        <td><?= $d['nomor_hp'] ?></td>
                        <td><?= $d['email'] ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</main>
<?= $this->endSection() ?>