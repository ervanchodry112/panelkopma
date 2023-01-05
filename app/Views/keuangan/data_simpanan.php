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
                    <div class="card-body">
                        <!-- Buat Konten Disini -->
                        <div class="row mx-2 my-3">
                            <div class="col d-flex justify-content-between">
                                <!-- Search Field -->
                                <form class="form w-50 d-flex align-items-center">
                                    <button type="submit" class="btn btn-sm">
                                        <ion-icon name="search-outline"></ion-icon>
                                    </button>
                                    <input name="search" type="search" class="form-control d-flex rounded-pill ms-1" style="height: 28px;" placeholder="Search" aria-label="Search" id="fieldSearch" autocomplete="off">
                                </form>
                                <!-- Search Fiela -->

                            </div>

                            <!-- Download Button -->
                            <div class="col justify-content-end d-flex">
                                <!-- <a href="toExcel.php" class="btn btn-success btn-sm p-auto rounded-pill shadow-sm d-flex justify-content-center" style="width: 35%;">
                                        <span class="me-1">
                                            <ion-icon style="font-size: 16px;" name="download-outline"></ion-icon>
                                        </span>
                                        <span>
                                            XLS
                                        </span>
                                    </a> -->
                            </div>
                            <!-- Download Button -->

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
                            <table class="table table-striped table-responsive tabel-data text-center w-100 fs-6" style="font-size: 12px;" id="tableData">
                                <thead>
                                    <th scope="col">#</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Nomor Anggota</th>
                                    <th scope="col">Simpanan Pokok</th>
                                    <th scope="col">Simpanan Wajib</th>
                                    <th scope="col">Total Simpanan</th>
                                    <th scope="col">Tagihan</th>
                                </thead>
                                <?php
                                $i = 1 + (25 * ($current_page - 1));
                                foreach ($simpanan as $d) {
                                    // dd($d['tgl_diksar']);
                                    $tagihan = 0;
                                    if ($d['tgl_diksar'] < '2022-01-01') {
                                        $tagihan = date_diff(date_create($d['tgl_diksar']), date_create('2022-01-01'))->m * 5000;
                                        $month = abs($date->difference('2022-01-01')->getMonths());
                                    } else {
                                        $month = abs($date->difference($d['tgl_diksar'])->getMonths());
                                    }
                                    $tagihan = ($tagihan + ($month * 10000)) - $d['simpanan_wajib'];
                                    // dd($tagihan);
                                    if ($tagihan < 0) {
                                        $tagihan = 0;
                                    }
                                ?>
                                    <tr>
                                        <th scope="row"><?= $i++ ?></th>
                                        <td>
                                            <form action="<?= base_url('keuangan/add_simpanan') ?>" method="post">
                                                <input type="hidden" name="nomor_anggota" value="<?= $d['nomor_anggota'] ?>">
                                                <button type="submit" class="btn btn-sm btn-warning">
                                                    <ion-icon name="add-outline"></ion-icon>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-start"><?= $d['nama_lengkap'] ?></td>
                                        <td><?= $d['nomor_anggota'] ?></td>
                                        <!-- <td class="text-start"></td> -->
                                        <td>Rp<?= number_format($d['simpanan_pokok'], 2) ?></td>
                                        <td>Rp<?= number_format($d['simpanan_wajib'], 2) ?></td>
                                        <td>Rp<?= number_format($d['simpanan_pokok'] + $d['simpanan_wajib'], 2) ?></td>
                                        <td>Rp<?= number_format($tagihan, 2) ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                            <?= $pager->links('data_simpanan', 'custom_pagination') ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- End #main -->

<?= $this->endSection(); ?>