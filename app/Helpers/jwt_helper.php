<?php

use App\Models\AnggotaModel;
use App\Models\SiJukoAccount;
use Firebase\JWT\JWT;

function getJWT($header)
{
    if (is_null($header)) {
        throw new Exception('Token tidak ditemukan');
    }
    return explode(" ", $header)[1];
}


function validateJWT($encodedToken)
{
    $key = getenv('JWT_SECRET_KEY');
    $decodedToken = JWT::decode($encodedToken, $key, array('HS256'));
    $akun = new SiJukoAccount();

    $data = $akun->where('username', $decodedToken->username)->first();
    if (!$data) {
        throw new Exception('Token tidak valid');
    }
}

function createJWT($username)
{
    $waktu_req = time();
    $waktu_valid = getEnv('JWT_VALID_TIME');
    $waktu_exp = $waktu_req + $waktu_valid;

    $anggota = new SiJukoAccount();
    $data = $anggota->select('nomor_anggota')->where('username', $username)->first();

    $payload = [
        'nomor_anggota' => $data->nomor_anggota,
        'username'  => $username,
        'iat'       => $waktu_req,
        'exp'       => $waktu_exp,
    ];

    $jwt = JWT::encode($payload, getenv('JWT_SECRET_KEY'), 'HS256');
    return $jwt;
}
