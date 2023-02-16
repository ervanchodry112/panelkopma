<?php
echo $this->extend('layout/template');

echo $this->section('sidebar');
?>

<main>
    <div class="container">
        <section class="section register min-vh-100 d-flex align-items-center justify-content-center pt -3 pb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                        <div class="d-flex justify-content-center py-4">
                        </div><!-- End Logo -->

                        <div class="card mb-3">

                            <div class="card-body ">
                                <div class="pt-4 pb-2 text-center">
                                    <img src="<?= base_url('/img/logo-kopma-unila.png') ?>" width="60rem" alt="Kopma Unila">
                                    <h5 class="card-title text-center pb-0 fs-4"><?= lang('Auth.loginTitle') ?></h5>
                                </div>
                                <?= view('Myth\Auth\Views\_message_block') ?>
                                <form action="<?= url_to('login') ?>" class="row g-3 needs-validation px-3" method="post">
                                    <?= csrf_field() ?>

                                    <div class="col-12">
                                        <label for="yourUsername" class="form-label">Username</label>
                                        <div class="input-group has-validation">
                                            <input type="text" name="login" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" id="yourUsername" required>
                                            <div class="invalid-feedback"><?= session('errors.login') ?></div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" id="yourPassword" required>
                                        <div class="invalid-feedback"><?= session('errors.password') ?></div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit"><?= lang('Auth.loginAction') ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
</main><!-- End #main -->

<?= $this->endSection() ?>