<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaModel;
use App\Models\Presensi;
use App\Models\SiJukoAccount;
use CodeIgniter\API\ResponseTrait;

class AuthApi extends BaseController
{
    use ResponseTrait;

    protected $akun_juko;
    protected $data_anggota;
    protected $presensi;

    public function __construct()
    {
        $this->akun_juko = new SiJukoAccount();
        $this->data_anggota = new AnggotaModel();
        $this->presensi = new Presensi();
    }
    public function register()
    {
        $nomor_anggota = $this->request->getVar('nomor_anggota');
        $password = $this->request->getVar('password');
        $username = substr($nomor_anggota, 0, 4) . substr($nomor_anggota, -2);

        $validation = [
            'nomor_anggota' => [
                'label' => 'Nomor Anggota',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[4]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'min_length' => '{field} minimal 4 karakter'
                ]
            ]
        ];

        if (!$this->validate($validation)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $cek = $this->data_anggota->like('nomor_anggota', $nomor_anggota)->first();
        $usercek = $this->akun_juko->like('username', $username)->first();
        if (!$cek) {
            return $this->failNotFound('Nomor Anggota Tidak Ditemukan');
        }
        if ($usercek) {
            return $this->failResourceExists('Username Sudah Terdaftar, Silakan hubungi admin');
        }

        $data = [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'nomor_anggota' => $cek['nomor_anggota'],
        ];

        if (!$this->akun_juko->insert($data, false)) {
            return $this->fail('Gagal Mendaftar', 500);
        }

        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Berhasil Mendaftar'
            ],
        ];

        return $this->respond($response, 201);
    }

    public function login()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $validation = [
            'username' => [
                'label' => 'Username',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[4]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'min_length' => '{field} minimal 4 karakter'
                ]
            ]
        ];

        if (!$this->validate($validation)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $cek = $this->akun_juko->like('username', $username)->first();
        if (!$cek) {
            return $this->failNotFound('Username Tidak Ditemukan');
        }

        if (!password_verify($password, $cek->password)) {
            return $this->fail('Password Salah', 400);
        }

        $data = $this->data_anggota->where('nomor_anggota', $cek->nomor_anggota)->first();

        helper('jwt');
        $response = [
            'status' => 200,
            'error' => null,
            'messages' => 'Berhasil Login',
            'data' => [
                'nomor_anggota' => $data['nomor_anggota'],
                'nama' => $data['nama_lengkap'],
                'username' => $username,
                'jurusan' => $data['jurusan'],
            ],
            'access_token' => createJWT($username)
        ];

        return $this->respond($response, 200);
    }
}
