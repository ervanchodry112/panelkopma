<?php
echo $this->extend('dashboard/sidebar');

echo $this->section('main');
?>

<main>
    <div class="container p-0">
        <div class="row pt-3 mb-3">
            <div class="col">
                <h4 class="ps-3">Tambah User</h4>
            </div>
            <hr>
        </div>

        <?= view('Myth\Auth\Views\_message_block') ?>
        <form action="<?= url_to('register') ?>" method="POST">
            <?= csrf_field(); ?>
            <div class="row m-3 w-75">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input type="text" name="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" id="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
                    <small id="userHelp" class="form-text text-muted"><?= lang('Auth.weNeverShare') ?></small>
                </div>
            </div>
            <div class="row m-3 w-75">
                <label for="username" class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-9">
                    <input type="text" name="username" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" id="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>">
                    <small id="userHelp" class="form-text text-muted"><?= lang('Auth.weNeverShare') ?></small>
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
                <button type="submit" class="btn btn-primary w-25 me-2"><?= lang('Auth.register') ?></button>
                <a href="<?= base_url() ?>/dashboard/data_user" class="col-3 btn btn-secondary ">Batal</a>
            </div>
        </form>

    </div>
</main>
<?= $this->endSection() ?>