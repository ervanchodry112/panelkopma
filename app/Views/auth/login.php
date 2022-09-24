<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="<?= base_url('/css/bootstrap.css') ?>">
    <link rel="stylesheet" href="<?= base_url('/css/style.css') ?>" />
    <link rel="shortcut icon" href="<?= base_url('/img/logo-kopma-unila.png'); ?>" />
</head>

<body>
    <div class="container my-5 shadow" id="login-form" style="border: 1px solid rgb(0,0,0,.1); border-radius: 15px;">
        <h1 class="text-center my-3"><?= lang('Auth.loginTitle') ?></h1>
        <hr class="w-75 mx-auto">

        <?= view('Myth\Auth\Views\_message_block') ?>
        <form action="<?= url_to('login') ?>" method="post">
            <?= csrf_field() ?>
            <div class="row w-75 mx-auto mb-3">
                <div class="col">
                    <label for="username"><?= lang('Auth.username') ?></label>
                    <input class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" type="text" name="login" id="username" placeholder="<?= lang('Auth.username') ?>" autocomplete="off">
                    <div class="invalid-feedback">
                        <?= session('errors.login') ?>
                    </div>
                </div>
            </div>
            <div class="row w-75 mx-auto mb-3">
                <div class="col">
                    <label for="pass"><?= lang('Auth.password') ?></label>
                    <input class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" type="password" name="password" id="password" placeholder="<?= lang('Auth.password') ?>">
                    <div class="invalid-feedback">
                        <?= session('errors.password') ?>
                    </div>
                </div>
            </div>

            <div class="row w-75 mx-auto mb-4">
                <div class="col">
                    <button type="submit" class="btn btn-primary btn-block w-100"><?= lang('Auth.loginAction') ?></button>
                </div>
            </div>
        </form>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="http://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="<?= base_url(); ?>/js/jsfunctions.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>/js/qrcode.js"></script>

</body>

</html>