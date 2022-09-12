<?php
echo $this->extend('dashboard/sidebar');

echo $this->section('main');
?>

<main>
    <div class="container p-0">
        <div class="row pt-3 mb-3">
            <div class="col">
                <h4 class="ps-3">Bayar Simpanan</h4>
            </div>
            <hr>
        </div>
        <form action="save_kegiatan" method="POST">
            <?= csrf_field(); ?>
            <div class="row m-3 w-75">
                <label for="npm" class="col-sm-3 col-form-label">NPM</label>
                <div class="col-sm-9">
                    <input type="text" name="npm" class="form-control" id="npm" value="<?= $npm ?>" disabled>
                </div>
            </div>
            <div class="row m-3 w-75">
                <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                <div class="col-sm-9">
                    <input type="text" name="nama" class="form-control" id="nama" value="<?= $nama['nama_lengkap'] ?>" disabled>
                </div>
            </div>
            <div class="row m-3 w-75">
                <label for="nominal" class="col-sm-3 form-label">Nominal Pembayaran</label>
                <div class="col-sm-9 input-group w-75">
                    <span class="input-group-text">Rp</span>
                    <input type="text" name="nominal" class="form-control" id="nominal" placeholder="0">
                </div>
            </div>

            <?php
            if (session()->getFlashdata('pesan')) { ?>
                <div class="row ms-4 w-75">
                    <div class="col-12 alert alert-success" role="alert">
                        Data berhasil ditambahkan!
                    </div>
                </div>
            <?php
            }
            ?>

            <div class="row ms-4 w-75">
                <button type="submit" class="col-3 me-2 btn btn-sm btn-primary">Tambah</button>
                <a href="data_simpanan" class="col-3 btn btn-secondary btn-sm">Batal</a>
            </div>
        </form>

    </div>
</main>
<?= $this->endSection() ?>