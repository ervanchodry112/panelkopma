<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $file ?></title>
    <link rel="icon" href="<?= base_url('img/logo-kopma-unila.png') ?>">
</head>

<body style="margin: 0; padding: 0;">
    <embed src="<?= base_url('assets/uploads/document/digilib/' . $file) ?>" type="application/pdf" , width="100%" style="height: 100vh;">
</body>

</html>