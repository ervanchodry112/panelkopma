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

                        <?php
                        if (session()->getFlashdata('pesan')) {
                            echo session()->getFlashdata('pesan');
                        }
                        ?>

                        <form action="<?= base_url('admin/attempt_reset') ?>" method="POST">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="id" value="<?= $user->id ?>">
                            <div class="row m-3 w-75">
                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" name="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" id="email" placeholder="<?= lang('Auth.email') ?>" value="<?= $user->email ?>" disabled>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="username" class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-9">
                                    <input type="text" name="username" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" id="username" placeholder="<?= lang('Auth.username') ?>" value="<?= $user->username ?>" disabled>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="password" class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-9">
                                    <input type="password" name="password" id="password" placeholder="<?= lang('Auth.password') ?>" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('password') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-3 w-75">
                                <label for="pass_confirm" class="col-sm-3 col-form-label"><?= lang('Auth.repeatPassword') ?></label>
                                <div class="col-sm-9">
                                    <input type="password" name="pass_confirm" id="pass_confirm" placeholder="<?= lang('Auth.repeatPassword') ?>" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('pass_confirm') ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row ms-4 w-75">
                                <button type="submit" class="btn btn-primary w-25 me-2">Simpan</button>
                                <a href="<?= base_url('admin/data_user') ?>" class="col-3 btn btn-secondary ">Batal</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- End #main -->

<main>
    <div class="container p-0">

    </div>
</main>
<?= $this->endSection() ?>