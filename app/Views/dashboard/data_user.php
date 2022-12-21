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
                            <div class="col d-flex justify-content-between">
                                <!-- Search Fiela -->
                                <div class="col d-flex align-items-center">
                                    <a class="btn btn-success btn-sm text-white align-items-center me-2 rounded-3" href="<?= base_url('dashboard/add_user') ?>">
                                        <span class="fs-6 align-middle">
                                            <ion-icon name="add-outline"></ion-icon>
                                        </span>
                                        <span class="align-middle">Add</span>
                                    </a>
                                    <ion-icon name="search-outline" class="ms-auto"></ion-icon>
                                    <form class="form w-25">
                                        <input type="search" class="form-control d-flex rounded-pill ms-1" style="height: 28px;" placeholder="Search" aria-label="Search" id="fieldSearch" autocomplete="off">
                                    </form>
                                </div>
                                <!-- Search Field -->

                                <!-- </div> -->
                            </div>
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
                            <table class="table table-striped table-responsive fs-6" style="font-size: 12px;" id="tableData">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Password</th>
                                        <th scope="col">Role</th>
                                    </tr>
                                </thead>
                                <?php $i = 1;
                                foreach ($user as $d) { ?>
                                    <tr>
                                        <th scope="row"><?= $i++ ?></th>
                                        <td><?= $d->username ?></td>
                                        <td>******</td>
                                        <td><?= ucwords($d->name) ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                            <?= $pager->links('data_anggota', 'custom_pagination') ?>
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