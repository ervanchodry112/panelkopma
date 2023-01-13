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
                        <div class="container overflow-scroll">
                            <table class="table table-striped table-responsive tabel-data fs-6" id="tableData">
                                <tr>
                                    <?php
                                    if (has_permission('mengelola_keuangan')) {
                                    ?>
                                        <th scope="col">Action</th>
                                    <?php
                                    }
                                    ?>
                                    <th scope="col">No. Ref</th>
                                    <th scope="col">Waktu</th>
                                    <th scope="col">Nama Lengkap</th>
                                    <th scope="col">Nomor Anggota</th>
                                    <th scope="col">Nominal</th>
                                    <th scope="col">Bukti</th>
                                    <th scope="col">Status</th>
                                </tr>
                                <?php $i = 1 + (25 * ($current_page - 1));
                                foreach ($simwa as $d) {
                                    /*dd($d['created_at'])*/ ?>

                                    <tr>
                                        <?php
                                        if (has_permission('mengelola_keuangan')) {
                                        ?>
                                            <td>
                                                <?php
                                                if ($d['status'] == 1) {
                                                ?>
                                                    <a href="<?= base_url('keuangan/accept/' . $d['id_pembayaran']) ?>" type="button" class="btn btn-success btn-sm">
                                                        <ion-icon name="checkmark-circle-outline"></ion-icon>
                                                    </a>
                                                    <a href="<?= base_url('keuangan/reject/' . $d['id_pembayaran']) ?>" type="button" class="btn btn-danger btn-sm">
                                                        <ion-icon name="ban-outline"></ion-icon>
                                                    </a>
                                                <?php
                                                } else {
                                                    echo '-';
                                                }
                                                ?>
                                            </td>
                                        <?php
                                        }
                                        ?>
                                        <td><?= $d['id_pembayaran'] ?></td>
                                        <td><?= $d['created_at'] ?></td>
                                        <td><?= $d['nama_lengkap'] ?></td>
                                        <td><?= $d['nomor_anggota'] ?></td>
                                        <td>Rp<?= number_format($d['nominal'], 2) ?></td>
                                        <td>
                                            <?php
                                            if ($d['bukti_pembayaran'] == '-') {
                                                echo "-";
                                            } else {
                                            ?>
                                                <a target="blank" href="" class="btn btn-sm btn-primary">
                                                    <span clas>
                                                        <ion-icon name="eye-outline"></ion-icon>
                                                    </span>
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <div class="badge bg-<?= ($d['status'] == 1 ? 'warning' : ($d['status'] == 2 ? 'danger' : 'success')) ?>">
                                                <?= ($d['status'] == 1 ? 'Pending' : ($d['status'] == 2 ? 'Rejected' : "Accepted")) ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
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