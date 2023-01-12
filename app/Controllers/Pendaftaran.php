<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CalonModel;
use CodeIgniter\I18n\Time;

class Pendaftaran extends BaseController
{
    protected $daftar;

    public function __construct()
    {
        $this->daftar = new CalonModel();
    }

    public function index()
    {
        // $fak = $this->fakultas->findAll();
        $info = [
            'Instagram',
            'Teman',
            'Tiktok',
            'Facebook',
            'Website',
            'Lainnya',
        ];
        $fak = [
            'Fakultas Matematika dan Ilmu Pengetahuan Alam',
            'Fakultas Teknik',
            'Fakultas Ekonomi dan Bisnis',
            'Fakultas Ilmu Sosial dan Ilmu Politik',
            'Fakultas Keguruan dan Ilmu Pendidikan',
            'Fakultas Kedokteran',
            'Fakultas Pertanian',
            'Fakultas Hukum',
        ];
        $data = [
            'title' => 'Pendaftaran Kopma Unila',
            'fakultas' => $fak,
            'informasi' => $info,
            'validation' => \Config\Services::validation()
        ];
        return view('pendaftaran/form-daftar', $data);
    }

    public function daftar_calon()
    {
        $input = $this->request->getVar();
        // dd($input);
        $validation = [
            'npm' => [
                'rules' => 'required|numeric|exact_length[10]|is_unique[calon_anggota.npm]',
                'errors' => [
                    'required' => 'NPM tidak boleh kosong',
                    'numeric' => 'NPM harus berupa angka',
                    'exact_length' => 'NPM harus berjumlah 10 digit'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email tidak boleh kosong',
                    'valid_email' => 'Email tidak valid'
                ]
            ],
            'name'  => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong'
                ]
            ],
            'call'  => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama panggilan tidak boleh kosong'
                ],
            ],
            'fakultas'  => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Fakultas tidak boleh kosong'
                ],
            ],
            'jurusan'   => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jurusan tidak boleh kosong'
                ],
            ],
            'jenis_kelamin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis kelamin tidak boleh kosong'
                ],
            ],
            'tempat_lahir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal lahir tidak boleh kosong'
                ],
            ],
            'tanggal_lahir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal lahir tidak boleh kosong'
                ],
            ],
            'alasan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alasan tidak boleh kosong'
                ],
            ],
            'domisili' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Domisili tidak boleh kosong'
                ],
            ],
            'nomor_hp' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Nomor HP tidak boleh kosong',
                    'numeric' => 'Nomor HP harus berupa angka'
                ],
            ],
            'asal_informasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Asal informasi tidak boleh kosong'
                ],
            ],
            'foto' => [
                'rules' => 'uploaded[foto]|max_size[foto,5120]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Foto tidak boleh kosong',
                    'max_size' => 'Ukuran foto maksimal 5 MB',
                    'is_image' => 'File yang diupload bukan gambar',
                    'mime_in' => 'File yang diupload bukan gambar'
                ],
            ],
            'ktm' => [
                'rules' => 'uploaded[ktm]|max_size[ktm,5120]|is_image[ktm]|mime_in[ktm,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'KTM tidak boleh kosong',
                    'max_size' => 'Ukuran foto maksimal 5 MB',
                    'is_image' => 'File yang diupload bukan gambar',
                    'mime_in' => 'File yang diupload bukan gambar'
                ],
            ],
            'bukti_pembayaran' => [
                'rules' => 'uploaded[bukti_pembayaran]|max_size[bukti_pembayaran,5120]|is_image[bukti_pembayaran]|mime_in[bukti_pembayaran,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Bukti Pembayaran tidak boleh kosong',
                    'max_size' => 'Ukuran foto maksimal 5 MB',
                    'is_image' => 'File yang diupload bukan gambar',
                    'mime_in' => 'File yang diupload bukan gambar'
                ],
            ],
        ];

        if (!$this->validate($validation)) {
            return redirect()->to('/pendaftaran')->withInput();
        }

        $foto = $this->request->getFile('foto');
        $ktm = $this->request->getFile('ktm');
        $bukti_pembayaran = $this->request->getFile('bukti_pembayaran');

        $dir = 'assets/uploads/document/regist/';

        // dd($foto->getExtension());
        $n_foto = $foto->getRandomName();
        $n_ktm = $ktm->getRandomName();
        $n_bukti_pembayaran = $bukti_pembayaran->getRandomName();

        $foto->move($dir . 'foto', $n_foto);
        $ktm->move($dir . 'ktm', $n_ktm);
        $bukti_pembayaran->move($dir . 'bukti_pembayaran', $n_bukti_pembayaran);

        $save = [
            'npm' => $input['npm'],
            'nama_lengkap' => $input['name'],
            'jenis_kelamin' => $input['jenis_kelamin'],
            'jurusan' => $input['jurusan'],
            'fakultas' => $input['fakultas'],
            'kode_referal' => $input['kode_referal'],
            'email' => $input['email'],
            'nomor_hp' => $input['nomor_hp'],
            'domisili'      => $input['domisili'],
            'alasan'        => $input['alasan'],
            'asal_informasi'    => $input['asal_informasi'],
            'nama_panggilan'    => $input['call'],
            'tempat_lahir'      => $input['tempat_lahir'],
            'tanggal_lahir'     => $input['tanggal_lahir'],
            'foto'              => $n_foto,
            'ktm'               => $n_ktm,
            'bukti_pembayaran'  => $n_bukti_pembayaran,
        ];

        if (!$this->daftar->insert($save, false)) {
            return redirect()->to('pendaftaran/gagal')->with('error', 'Gagal mendaftar');
        }

        return redirect()->to('pendaftaran/sukses')->with('success', 'Berhasil mendaftar');
    }

    public function gagal()
    {
        $data = [
            'title' => 'Gagal Mendaftar'
        ];

        return view('pendaftaran/gagal', $data);
    }

    public function sukses()
    {
        $data = [
            'title' => 'Berhasil Mendaftar'
        ];

        return view('pendaftaran/sukses', $data);
    }
}
