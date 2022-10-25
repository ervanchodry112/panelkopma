<?php
echo $this->extend('dashboard/sidebar');

echo $this->section('main');
?>

<main>
    <div class="container p-0">
        <div class="row pt-3 mb-3">
            <div class="col">
                <h4 class="ps-3">Tambah Data Referal</h4>
            </div>
            <hr>
        </div>
        <form action="<?= base_url('psda/save_referal') ?>" method="POST">
            <?= csrf_field(); ?>
            <div class="row m-3 w-75">
                <label for="nama_lengkap" class="col-sm-3 col-form-label">Nama Lengkap</label>
                <div class="col-sm-9">
                    <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" placeholder="Nama Lengkap" autofocus>
                </div>
            </div>
            <div class="row m-3 w-75">
                <label for="nomor_anggota" class="col-sm-3 col-form-label">Nomor Anggota</label>
                <div class="col-sm-9">
                    <input type="text" name="nomor_anggota" class="form-control" id="nomor_anggota" placeholder="Nomor Anggota">
                </div>
            </div>
            <div class="row m-3 w-75">
                <label for="referal" class="col-sm-3 col-form-label">Kode Referal</label>
                <div class="col-sm-9">
                    <input type="text" name="referal" class="form-control" id="referal" placeholder="Kode Referal">
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
                session()->remove('pesan');
            }
            ?>

            <div class="row ms-4 w-75">
                <button type="submit" class="col-3 me-2 btn btn-sm btn-primary">Tambah</button>
                <a href="<?= base_url('psda/kode_referal') ?>" class="col-3 btn btn-secondary btn-sm">Batal</a>
            </div>
        </form>

    </div>
</main>
<?= $this->endSection() ?>