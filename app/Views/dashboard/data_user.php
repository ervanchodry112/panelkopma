<?= $this->extend('dashboard/sidebar') ?>

<?= $this->section('main') ?>
<main id="main" class="main">
    <section class="section dashboard">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header mx-3 pt-4">

                        <h3><?= $title ?></h3>
                    </div>
                    <div class="card-body pt-3">

                        <div class="row mx-1 mb-3">
                            <div class="col d-flex justify-content-between align-items-center">
                                <!-- Search Fiela -->
                                <a class="btn btn-success btn-sm text-white align-items-center me-2 rounded-3" href="<?= base_url('admin/add_user') ?>">
                                    <ion-icon name="add-outline"></ion-icon>
                                    Add
                                </a>
                                <!-- Search Field -->

                                <!-- </div> -->
                            </div>
                        </div>
                        <?php
                        if (session()->has('pesan')) {
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
                            <table class="table table-striped table-responsive fs-6" style="font-size: 12px;" id="tableData">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <?php $i = 1;
                                foreach ($user as $d) { ?>
                                    <tr>
                                        <th scope="row"><?= $i++ ?></th>
                                        <td><?= $d->username ?></td>
                                        <td><?= ucwords($d->name) ?></td>
                                        <td class="w-100 d-flex justify-content-start">
                                            <form action="<?= base_url('admin/reset_password') ?>" class="me-2" method="post">
                                                <input type="hidden" name="id" value="<?= $d->username ?>">
                                                <button type="submit" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-key"></i>
                                                </button>
                                            </form>
                                            <form action="<?= base_url('admin/delete_user') ?>" method="post">
                                                <input type="hidden" name="id" value="<?= $d->username ?>">
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <ion-icon name="trash-outline"></ion-icon>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Buat Konten Disini -->
        </div>
    </section>
</main>
<main>
    <div class="container p-0">
        <div class="row pt-3 mb-3">
            <div class="col">
                <h4 class="ps-3">User</h4>
            </div>
            <hr>
        </div>
    </div>
</main>
<?= $this->endSection() ?>