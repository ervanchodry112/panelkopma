<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title ?></title>
    <link rel="shortcut icon" href="<?= base_url('img/logo-kopma-unila.png') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.css') ?>" />

</head>

<body>
    <div class="container d-flex align-items-center" style="height: 100vh;">
        <div class="container shadow p-4 mt-3 w-auto">
            <div class="row">
                <div class="col-12">
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
                            <h1><strong>Mohon Maaf!</strong></h1>
                        </div>
                    </div>

                    <hr />
                    <div class="row justify-content-center">
                        <div class="col-sm-7 text-center mt-3">
                            <p>Pendaftaran yang anda lakukan tidak dapat diproses, silakan menghubungi Contact Person melalui tombol dibawah</p>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-sm-7 text-center">

                            <!-- Ganti nomor WA di href ini sesuai dengan nomor yang bertanggung jawab di tahun kepengurusan tersebut -->
                            <a href="https://wa.me/6289673116170">
                                <button class="btn btn-success mt-3 p-2">
                                    <div class="row justify-content-center align-middle">
                                        <div class="col-1">
                                            <ion-icon style="font-size: 22px" name="logo-whatsapp"></ion-icon>
                                        </div>
                                        <div class="col-10">
                                            <div>Contact Person</div>
                                        </div>
                                    </div>
                                </button>
                            </a>
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
</body>

</html>