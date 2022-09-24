<?php
echo $this->extend('dashboard/sidebar');
echo $this->section('main');
?>

<main>
    <div class="container p-0">
        <div class="row pt-3 mb-3">
            <div class="col">
                <h4 class="ps-3">Pembayaran Simpanan</h4>
            </div>
            <hr>
        </div>
        <div class="row mx-2 mb-2">
            <div class="col d-flex justify-content-between">
                <!-- Search Fiela -->
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
            foreach ($simwa as $d) { ?>
                <tr>
                    <?php
                    if (has_permission('mengelola_keuangan')) {
                    ?>
                        <td>
                            <?php
                            if ($d['status'] == 1) {
                            ?>
                                <a href="/keuangan/accept/<?= $d['id_pembayaran'] ?>" type="button" class="btn btn-success btn-sm">
                                    <ion-icon name="checkmark-circle-outline"></ion-icon>
                                </a>
                                <a href="/keuangan/reject/<?= $d['id_pembayaran'] ?>" type="button" class="btn btn-danger btn-sm">
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
                    <td><?= $d['nominal'] ?></td>
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
                    <td class="<?= ($d['status'] == 1 ? 'text-warning' : ($d['status'] == 2 ? 'text-danger' : 'text-success')) ?>">
                        <?= ($d['status'] == 1 ? 'Pending' : ($d['status'] == 2 ? 'Rejected' : "Accepted")) ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    </div>
</main>

<?= $this->endSection() ?>