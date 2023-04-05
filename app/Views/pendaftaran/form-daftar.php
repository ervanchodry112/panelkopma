<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pendaftaran Calon Anggota</title>
    <link rel="shortcut icon" href="<?= base_url('img/logo-kopma-unila.png') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.css') ?>" />

    <style>
        label {
            padding-left: 5px;
        }

        .box {
            border-radius: 15px;
            width: 100%;
        }

        .bar-progress {
            position: relative;
            display: flex;
            justify-content: space-between;
            counter-reset: step;
        }

        .progress-step {
            width: 2.1875rem;
            height: 2.1875rem;
            background-color: #dcdcdc;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .bar-progress::before,
        .progress {
            content: "";
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            height: 4px;
            width: 100%;
            background-color: #dcdcdc;
            z-index: -1;
        }

        .progress {
            background-color: #0086df;
            width: 0%;
            transition: 1s;
        }

        .progress-step::before {
            counter-increment: step;
            content: counter(step);
        }

        .progress-step-active {
            background-color: #0086df;
            color: white;
            transition: 1s;
        }

        .form-step {
            display: none;
            transition: 1s;
        }

        .form-step-active {
            display: block;
        }

        .slide-bottom {
            animation: slide-bottom .5s ease-in-out;
        }

        @keyframes slide-bottom {
            0% {
                transform: translateY(20px);
            }

            100% {
                transform: translateY(0);
            }
        }

        #call-me {
            top: 90%;
            left: 95%;
        }

        @media screen and (max-width: 600px) {
            #call-me {
                top: 90%;
                left: 80%;
            }
        }
    </style>
</head>

<body>

    <!-- Ganti nomor wa di bawah sesuai nomor cp tiap periode -->
    <a href="https://wa.me/6289627057971" target="blank" id="call-me" class="btn btn-success position-absolute rounded-circle fs-4 position-sticky">
        <ion-icon name="logo-whatsapp"></ion-icon>
    </a>
    <!-- TODO: Create a sticky whatsapp button for more information-->
    <div class="container">
        <div class="container shadow align-items-center p-4 mt-3 box">

            <div class="row">
                <!-- <div class="col-md-5 border-0 bg-danger align-items-center left-bg"></div> -->
                <div class="col-md-12">
                    <!-- Start Row Logo -->
                    <div class="row">
                        <div class="d-inline-flex justify-content-center">
                            <img class="img-fluid me-2" width="50px" src="<?= base_url('img/logo unila.png') ?>" alt="" />
                            <img width="50px" src="<?= base_url('img/logo-kopma-unila.png') ?>" alt="" />
                        </div>
                    </div>
                    <!-- End Row Logo ---
     
                              <!-- Start Row Judul -->
                    <div class="row text-center mt-3">
                        <div class="col-12">
                            <h1>Pendaftaran Calon Anggota</h1>
                        </div>
                    </div>

                    <!-- End Row Judul -->
                    <hr />

                    <!-- Start Row Form -->
                    <div class="row">
                        <div class="col m-auto">
                            <div class="row mb-3">
                                <div class="col-sm-4 m-auto">
                                    <div class="bar-progress">
                                        <div class="progress progress-bar-striped progress-bar-animated" id="progress"></div>
                                        <div class="progress-step progress-step-active"></div>
                                        <div class="progress-step"></div>
                                        <div class="progress-step"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Start Form Input -->
                            <form class="g-5" action="<?= base_url('pendaftaran/daftar_calon') ?>" method="POST" enctype="multipart/form-data" id="form-regist">
                                <div class="form-step slide-bottom form-step-active">
                                    <!-- Row NPM dan Email -->
                                    <div class="row mb-3 w-100 m-0 input-group ">
                                        <div class="col-sm-6">
                                            <label for="npm" style="font-size: 17px; margin-bottom: 5px">NPM</label>
                                            <div class="form-floating-sm text-muted">
                                                <input type="text" class="form-control <?= ($validation->hasError('npm') ? 'is-invalid' : '') ?>" value="<?= old('npm') ?>" name=" npm" id="npm" placeholder="NPM">
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('npm') ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="email" style="font-size: 17px; margin-bottom: 5px">E-Mail</label>
                                            <div class="form-floating-sm text-muted">
                                                <input type="email" class="form-control <?= ($validation->hasError('email') ? 'is-invalid' : '') ?>" value="<?= old('email') ?>" name=" email" id="email" placeholder="example@email.com">
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('email') ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Row NPM dan Email -->
                                    <!-- Start Row Nama Lengkap dan Nama Panggilan -->
                                    <div class="row mb-3 w-100 m-0 input-group">
                                        <div class="col-sm-6">
                                            <label for="name" style="font-size: 17px; margin-bottom: 5px">Nama Lengkap</label>
                                            <div class="form-floating-sm text-muted">
                                                <input type="text" class="form-control <?= ($validation->hasError('name') ? 'is-invalid' : '') ?>" value="<?= old('name') ?>" name="name" id="name" placeholder="Nama Lengkap">
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('name') ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-1">
                                            <label for="call">Nama Panggilan</label>
                                            <div class="form-floating-sm text-muted">
                                                <input type="text" class="form-control <?= ($validation->hasError('call') ? 'is-invalid' : '') ?>" value="<?= old('call') ?>" name="call" id="call" placeholder="Nama Panggilan" />
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('call') ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Row Nama Lengkap dan Nama Panggilan -->

                                    <!-- Start Row Fakultas dan Jurusan -->
                                    <div class="row mb-3 w-100 m-0 input-group">
                                        <div class="col-sm-6">
                                            <label for="fakultas" style="font-size: 17px; margin-bottom: 5px">Fakultas</label>
                                            <div class="form-floating-sm text-muted">
                                                <select class="form-select <?= ($validation->hasError('fakultas') ? 'is-invalid' : '') ?>" value="<?= old('fakultas') ?>" name="fakultas" id="fakultas" aria-label="form-select">
                                                    <?php foreach ($fakultas as $data) { ?>
                                                        <option value="<?= $data ?>" <?= ($data == old('fakultas' ? 'selected' : '')) ?>><?= $data ?></option>
                                                    <?php } ?>
                                                </select>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('fakultas') ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="jurusan" style="font-size: 17px; margin-bottom: 5px">Jurusan</label>
                                            <div class="form-floating-sm text-muted">
                                                <input type="text" name="jurusan" id="jurusan" class="form-control <?= ($validation->hasError('jurusan') ? 'is-invalid' : '') ?>" value="<?= old('jurusan') ?>" placeholder="Jurusan">
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('jurusan') ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row mb-3 w-100 m-0 justify-content-end">
                                        <div class="col-sm-2 align-self-end">
                                            <button type="button" class="btn btn-primary w-100 btn-next" id="next1">Next</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-step slide-bottom">
                                    <!-- Start Row Kode Referal dan Tanggal Lahir -->
                                    <div class="row mb-3 m-0 w-100">

                                        <div class="col-6">
                                            <label for="tempat_lahir" style="font-size: 17px; margin-bottom: 5px">Tempat Lahir</label>
                                            <div class="form-floating-sm text-muted">
                                                <input class="form-control <?= ($validation->hasError('tempat_lahir') ? 'is-invalid' : '') ?>" value="<?= old('tempat_lahir') ?>" type="text" name="tempat_lahir" id="tempat_lahir" placeholder="Tempat Lahir" />
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('tempat_lahir') ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label for="tanggal_lahir" style="font-size: 17px; margin-bottom: 5px">Tanggal Lahir</label>
                                            <div class="form-floating-sm text-muted">
                                                <input class="form-control <?= ($validation->hasError('tanggal_lahir') ? 'is-invalid' : '') ?>" value="<?= old('tanggal_lahir') ?>" type="date" name="tanggal_lahir" id="tanggal_lahir" />
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('tanggal_lahir') ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Row Kode Referal dan Tanggal Lahir -->

                                    <!-- Start Row Nomor HP -->
                                    <div class="row mb-3 m-0 w-100">
                                        <div class="col-sm-6">
                                            <label for="nomor_hp" style="font-size: 17px; margin-bottom: 5px">Nomor Whatsapp</label>
                                            <div class="form-floating-sm text muted">
                                                <input class="form-control <?= ($validation->hasError('nomor_hp') ? 'is-invalid' : '') ?>" value="<?= old('nomor_hp') ?>" type="text" name="nomor_hp" id="nomor_hp" placeholder="Nomor Whatsapp">
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('nomor_hp') ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="asal_informasi" style="font-size: 17px; margin-bottom: 5px">Asal Informasi</label>
                                            <div class="form-floating-sm text-muted">
                                                <select class="form-select <?= ($validation->hasError('asal_informasi') ? 'is-invalid' : '') ?>" value="<?= old('asal_informasi') ?>" name="asal_informasi" id="asal_informasi">
                                                    <?php foreach ($informasi as $info) { ?>
                                                        <option value="<?= $info ?>" <?= ($info == old('asal_informasi') ? 'selected' : '') ?>> <?= $info ?> </option>
                                                    <?php } ?>
                                                </select>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('asal_informasi') ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Start Row Alasan dan Domisili -->
                                    <div class="row mb-3 m-0 w-100">
                                        <div class="col-sm-6">
                                            <label for="alasan" style="font-size: 17px; margin-bottom: 5px">Alasan ikut Kopma </label>
                                            <div class="form-floating-sm text-muted">
                                                <textarea class="form-control <?= ($validation->hasError('alasan') ? 'is-invalid' : '') ?>" name="alasan" id="alasan" rows="3" placeholder="Alasan"><?= old('alasan') ?></textarea>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('alasan') ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="domisili" style="font-size: 17px; margin-bottom: 5px">Domisili</label>
                                            <div class="form-floating-sm text-muted">
                                                <textarea class="form-control <?= ($validation->hasError('domisili') ? 'is-invalid' : '') ?>" value="" name="domisili" id="domisili" rows="3" placeholder="Domisili"><?= old('domisili') ?></textarea>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('domisili') ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Row Alasan dan Domisili -->

                                    <div class="row mb-3 m-0 w-100">
                                        <div class="col-sm-6">
                                            <label for="jenis_kelamin" style="font-size: 17px; margin-bottom: 5px">Jenis Kelamin</label>
                                            <div class="form-floating-sm text-muted">
                                                <select class="form-select <?= ($validation->hasError('jenis_kelamin') ? 'is-invalid' : '') ?>" value="<?= old('jenis_kelamin') ?>" name="jenis_kelamin" id="jenis_kelamin">
                                                    <option value="L" <?= (old('jenis_kelamin') == 'L' ? 'selected' : '') ?>>Laki-Laki</option>
                                                    <option value="P" <?= (old('jenis_kelamin') == 'P' ? 'selected' : '') ?>>Perempuan</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('jenis_kelamin') ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row m-0 flex-sm-row-reverse justify-content-start g-2 mb-3 w-100">
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-primary w-100 btn-next" id="next2">Next</button>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-secondary w-100 btn-prev" id="prev1">Previous</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-step slide-bottom">
                                    <!-- Start Row Foto dan KTM -->
                                    <div class="row m-0 mb-3 w-100">
                                        <div class="col-sm-6">
                                            <label for="foto" style="font-size: 17px; margin-bottom: 5px">Foto</label>
                                            <div class="form-floating-sm text-muted">
                                                <input type="file" class="form-control <?= ($validation->hasError('foto') ? 'is-invalid' : '') ?>" value="<?= old('foto') ?>" name="foto" id="foto" />
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('foto') ?>
                                                </div>
                                            </div>
                                            <p class="text-muted" style="font-size: 14px;">*type file: jpg, png, jpeg; Maks Size: 5mb</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="ktm" style="font-size: 17px; margin-bottom: 5px">KTM</label>
                                            <div class="form-floating-sm text-muted">
                                                <input type="file" class="form-control <?= ($validation->hasError('ktm') ? 'is-invalid' : '') ?>" value="<?= old('ktm') ?>" name="ktm" id="ktm" />
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('ktm') ?>
                                                </div>
                                            </div>
                                            <p class="text-muted" style="font-size: 14px;">*type file: jpg, png, jpeg; Maks Size: 5mb</p>
                                        </div>
                                    </div>
                                    <!-- End Row Foto dan KTM -->

                                    <!-- Start Row Bukti Pembayaran dan Asal Informasi -->
                                    <div class="row m-0 mb-3 w-100">
                                        <div class="col-sm-6">
                                            <label for="bukti_pembayaran" style="font-size: 17px; margin-bottom: 5px">Bukti Pembayaran</label>
                                            <div class="form-floating-sm text-muted">
                                                <input type="file" class="form-control <?= ($validation->hasError('bukti_pembayaran') ? 'is-invalid' : '') ?>" value="<?= old('bukti_pembayaran') ?>" name="bukti_pembayaran" id="bukti_pembayaran" />
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('bukti_pembayaran') ?>
                                                </div>
                                            </div>
                                            <p class="text-muted" style="font-size: 14px;">*type file: jpg, png, jpeg; Maks Size: 5mb</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="kode_referal" style="font-size: 17px; margin-bottom: 5px">Kode Referal</label>
                                            <div class="form-floating-sm text-muted">
                                                <input class="form-control <?= ($validation->hasError('kode_referal') ? 'is-invalid' : '') ?>" value="<?= old('kode_referal') ?>" type="text" name="kode_referal" id="kode_referal" placeholder="Kode Referal" />
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('kode_referal') ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12" id="alert-message">
                                            <div class="alert alert-primary" role="alert">
                                                *Catatan : Pastikan Semua Isian telah terisi!
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Start Row Button -->
                                    <div class="row flex-sm-row-reverse mb-3 g-2 m-0 w-100">
                                        <div class="col-sm-2">
                                            <input class="btn btn-primary w-100" type="submit" value="submit" name="submit" id="submit">
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-secondary w-100 btn-prev" id="prev2">Previous</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TODO: Create Validation Script for Empty Input -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/bootstrap.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/popper.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/jsfunction.js') ?>"></script>
</body>

</html>