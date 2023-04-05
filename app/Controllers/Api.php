<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaModel;
use App\Models\HasilSurveyModel;
use App\Models\KegiatanModel;
use App\Models\LaporanKeuangan;
use App\Models\PembayaranSimwa;
use App\Models\PoinModel;
use App\Models\Presensi;
use App\Models\ProdukModel;
use App\Models\SiJukoAccount;
use App\Models\SimpananModel;
use App\Models\DigilibModel;
use App\Models\SurveyBerjalanModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Api extends BaseController
{
    use ResponseTrait;

    protected $akun_juko;
    protected $simpanan;
    protected $poin;
    protected $data_anggota;
    protected $data_kegiatan;
    protected $presensi;
    protected $survey_berjalan;
    protected $hasil_survey;
    protected $produk_usaha;
    protected $laporan_keuangan;
    protected $bayar_simwa;
    protected $digilib;

    public function __construct()
    {
        $this->akun_juko = new SiJukoAccount();
        $this->simpanan = new SimpananModel();
        $this->poin = new PoinModel();
        $this->data_anggota = new AnggotaModel();
        $this->data_kegiatan = new KegiatanModel();
        $this->presensi = new Presensi();
        $this->survey_berjalan = new SurveyBerjalanModel();
        $this->hasil_survey = new HasilSurveyModel();
        $this->produk_usaha = new ProdukModel();
        $this->laporan_keuangan = new LaporanKeuangan();
        $this->bayar_simwa = new PembayaranSimwa();
        $this->digilib = new DigilibModel();
    }
    public function reset_password()
    {
        $validation = [
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Username tidak boleh kosong',
                ],
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password tidak boleh kosong',
                ],
            ],
            'nomor_anggota' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor Anggota tidak boleh kosong',
                ],
            ],

        ];

        if (!$this->validate($validation)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $nomor_anggota = $this->request->getVar('nomor_anggota');

        $cek = $this->akun_juko->where('username', $username)->first();
        if (!$cek) {
            return $this->failNotFound('Username tidak ditemukan');
        }

        $data = [
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'nomor_anggota' => $nomor_anggota
        ];

        if (!$this->akun_juko->save($data)) {
            return $this->failServerError('Gagal mereset password');
        }

        $response = [
            'status' => 200,
            'error' => false,
            'messages' => 'Berhasil mereset password'
        ];
        return $this->respond($response, 200);
    }

    public function get_simpanan_poin()
    {
        $validation = [
            'nomor_anggota' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor Anggota tidak boleh kosong',
                ],
            ],
        ];

        if (!$this->validate($validation)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $nomor_anggota = $this->request->getVar('nomor_anggota');

        $data_simpanan = $this->simpanan->where('nomor_anggota', $nomor_anggota)->first();
        $data_poin = $this->poin->where('nomor_anggota', $nomor_anggota)->first();
        $d = $this->data_anggota->where('nomor_anggota', $nomor_anggota)->first();

        if (!$data_simpanan || !$data_poin) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        $data_poin = (($data_simpanan['simpanan_wajib'] / 10000) * 3) + $data_poin['poin'];

        $response = [
            'status' => 200,
            'error' => false,
            'messages' => 'Berhasil mendapatkan data',
            'data' => [
                'nomor_anggota' => $nomor_anggota,
                'simpanan_wajib' => $data_simpanan['simpanan_wajib'],
                'simpanan_pokok' => $data_simpanan['simpanan_pokok'],
                'tagihan' => $data_simpanan['tagihan'] != null ? $data_simpanan['tagihan'] : 0,
                'poin' => $data_poin,
            ]
        ];

        return $this->respond($response, 200);
    }

    public function presensi()
    {
        $validation = [
            'nomor_anggota' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor Anggota tidak boleh kosong',
                ],
            ],
            'id_kegiatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'ID Kegiatan tidak boleh kosong',
                ],
            ],
        ];

        if (!$this->validate($validation)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $nomor_anggota = $this->request->getVar('nomor_anggota');
        $id_kegiatan = $this->request->getVar('id_kegiatan');

        $kegiatan = $this->data_kegiatan->where('id_kegiatan', $id_kegiatan)->first();
        $anggota = $this->data_anggota->where('nomor_anggota', $nomor_anggota)->first();

        if (!$kegiatan || !$anggota) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        $present = $this->presensi->where('id_kegiatan', $id_kegiatan)->where('id_data', $nomor_anggota)->first();

        if ($present) {
            return $this->failResourceExists('Anda sudah melakukan presensi pada kegiatan ini');
        }
        $save = [
            'waktu' => Time::now('Asia/Jakarta', 'id_ID'),
            'id_data' => $nomor_anggota,
            'id_kegiatan' => $id_kegiatan,
        ];

        if (!$this->presensi->save($save)) {
            return $this->failServerError('Gagal melakukan presensi');
        }


        $response = [
            'status' => 200,
            'error' => false,
            'messages' => 'Berhasil melakukan presensi',
            'data' => [
                'nomor_anggota' => $nomor_anggota,
                'nama' => $anggota['nama_lengkap'],
                'id_kegiatan' => $id_kegiatan,
                'nama_kegiatan' => $kegiatan['nama_kegiatan'],
                'waktu' => Time::now('Asia/Jakarta', 'id_ID')->getTimestamp(),
            ]
        ];

        return $this->respond($response, 200);
    }

    public function survey_berjalan()
    {
        $max = 15;
        if ($this->request->getVar('max')) {
            $max = $this->request->getVar('max');
        }

        $survey = $this->survey_berjalan->select('id, nama_survey, deskripsi, tgl_mulai, tgl_selesai, link')
            ->orderBy('tgl_mulai', 'ASC')->where('tgl_selesai >= ', Time::now())->findAll($max);

        if (!$survey) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        $response = [
            'status' => 200,
            'error' => false,
            'messages' => 'Berhasil mendapatkan data',
            'data' => $survey
        ];

        return $this->respond($response, 200);
    }

    public function hasil_survey()
    {
        $max = 10;
        $page = 1;
        $search = $this->request->getVar('search');
        if ($this->request->getVar('max')) {
            $max = $this->request->getVar('max');
        }
        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        }
        if ($search) {
            $report = $this->hasil_survey->select('id_laporan, nama_survey, deskripsi, tanggal_mulai, tanggal_selesai, jumlah_responden, file')
                ->like('nama_survey', $search)->orderBy('tanggal_selesai', 'DESC')->findAll($max, ($page - 1) * $max);
        } else {
            $report = $this->hasil_survey->select('id_laporan, nama_survey, deskripsi, tanggal_mulai, tanggal_selesai, jumlah_responden, file')
                ->orderBy('tanggal_selesai', 'DESC')->findAll($max, ($page - 1) * $max);
        }

        if (!$report) {
            return $this->failNotFound('Data tidak ditemukan');
        }
        foreach ($report as $key => $value) {
            $report[$key]['file'] = base_url('assets/uploads/document/hasil_survey/' . $value['file']);
        }

        $response = [
            'status' => 200,
            'error' => false,
            'messages' => 'Berhasil mendapatkan data',
            'data' => $report
        ];

        return $this->respond($response, 200);
    }

    public function produk_usaha()
    {
        $max = 10;
        $page = 1;
        $search = $this->request->getVar('search');
        if ($this->request->getVar('max')) {
            $max = $this->request->getVar('max');
        }
        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        }
        if ($search) {
            $produk = $this->produk_usaha->select('id_produk, nama_produk, harga_produk, gambar_produk')
                ->like('nama_produk', $search)->orderBy('nama_produk', 'ASC')->findAll($max, ($page - 1) * $max);
        } else {
            $produk = $this->produk_usaha->select('id_produk, nama_produk, harga_produk, gambar_produk')
                ->orderBy('nama_produk', 'ASC')->findAll($max, ($page - 1) * $max);
        }

        if (!$produk) {
            return $this->failNotFound('Data tidak ditemukan');
        }
        foreach ($produk as $key => $value) {
            $produk[$key]->gambar_produk = base_url('assets/uploads/img/produk/' . $value->gambar_produk);
        }

        $response = [
            'status' => 200,
            'error' => false,
            'messages' => 'Berhasil mendapatkan data',
            'data' => $produk
        ];

        return $this->respond($response, 200);
    }

    public function laporan_keuangan()
    {
        $max = 10;
        $page = 1;
        $search = $this->request->getVar('search');
        if ($this->request->getVar('max')) {
            $max = $this->request->getVar('max');
        }
        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        }
        if ($search) {
            $report = $this->laporan_keuangan->select('id, judul, bulan, tahun, file')
                ->like('judul', $search)->orderBy('tahun', 'DESC')->orderBy('bulan', 'DESC')->findAll($max, ($page - 1) * $max);
        } else {
            $report = $this->laporan_keuangan->select('id, judul, bulan, tahun, file')
                ->orderBy('tahun', 'DESC')->orderBy('bulan', 'DESC')->findAll($max, ($page - 1) * $max);
        }

        if (!$report) {
            return $this->failNotFound('Data tidak ditemukan');
        }
        foreach ($report as $key => $value) {
            $report[$key]->file = base_url('assets/uploads/document/laporan_keuangan/' . $value->file);
        }

        $response = [
            'status' => 200,
            'error' => false,

            'messages' => 'Berhasil mendapatkan data',
            'data' => $report
        ];

        return $this->respond($response, 200);
    }

    public function get_biodata()
    {
        $validation = [
            'nomor_anggota' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor anggota harus diisi'
                ]
            ],
        ];
        if (!$this->validate($validation)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $nomor_anggota = $this->request->getVar('nomor_anggota');

        $data = $this->data_anggota->select('nomor_anggota, npm, nama_lengkap, email, jenis_kelamin, nomor_hp, jurusan, fakultas')
            ->where('nomor_anggota', $nomor_anggota)->first();
        if (!$data) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        $response = [
            'status' => 200,
            'error' => false,
            'messages' => 'Berhasil mendapatkan data',
            'data' => $data
        ];

        return $this->respond($response, 200);
    }

    public function update_biodata()
    {
        $validation = [
            'nomor_anggota' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor anggota harus diisi'
                ]
            ],
            'npm' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NPM harus diisi'
                ]
            ],
            'nama_lengkap' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama lengkap harus diisi'
                ]
            ],
            'email' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Email harus diisi'
                ]
            ],
            'jenis_kelamin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis kelamin harus diisi'
                ]
            ],
            'nomor_hp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor HP harus diisi'
                ]
            ],
            'jurusan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jurusan harus diisi',
                ]
            ],
            'fakultas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Fakultas harus diisi',
                ]
            ],
        ];
        if (!$this->validate($validation)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = $this->data_anggota->select('nomor_anggota')
            ->like('nomor_anggota', $this->request->getVar('nomor_anggota'))->first();

        if (!$data) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        $data = [
            'nomor_anggota' => $this->request->getVar('nomor_anggota'),
            'npm' => $this->request->getVar('npm'),
            'nama_lengkap' => $this->request->getVar('nama_lengkap'),
            'email' => $this->request->getVar('email'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'nomor_hp' => $this->request->getVar('nomor_hp'),
            'jurusan' => $this->request->getVar('jurusan'),
            'fakultas' => $this->request->getVar('fakultas'),
        ];

        if (!$this->data_anggota->save($data)) {
            return $this->failServerError('Gagal menyimpan data');
        }

        $response = [
            'status' => 200,
            'error' => false,
            'messages' => 'Berhasil menyimpan data',
        ];

        return $this->respond($response, 200);
    }

    public function bayar_simwa()
    {
        $validation = [
            'nomor_anggota' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor anggota harus diisi'
                ]
            ],
            'nominal' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Nominal harus diisi',
                    'numeric' => 'Nominal harus berupa angka'
                ]
            ],
            'bukti_pembayaran' => [
                'rules' => 'uploaded[bukti_pembayaran]|max_size[bukti_pembayaran,2048]|ext_in[bukti_pembayaran,png,jpg,jpeg]',
                'errors' => [
                    'uploaded' => 'Bukti pembayaran harus diisi',
                    'max_size' => 'Ukuran file maksimal 2 MB',
                    'ext_in' => 'Ekstensi file harus berupa PNG, JPG, atau JPEG'
                ]
            ],
        ];

        if (!$this->validate($validation)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = $this->data_anggota->select('nomor_anggota')
            ->where('nomor_anggota', $this->request->getVar('nomor_anggota'))->first();

        if (!$data) {
            return $this->failNotFound('Data tidak ditemukan');
        }

        $file = $this->request->getFile('bukti_pembayaran');
        $nama_file = $file->getRandomName();
        $file->move('assets/uploads/img/bukti_simwa', $nama_file);

        $data = [
            'id_pembayaran' => uniqid(),
            'timestamp' => Time::now('Asia/Jakarta', 'id_ID'),
            'nomor_anggota' => $this->request->getVar('nomor_anggota'),
            'nominal' => $this->request->getVar('nominal'),
            'status' => 1,
            'bukti_pembayaran' => $nama_file,
        ];

        if (!$this->bayar_simwa->insert($data, false)) {
            return $this->failServerError('Gagal menyimpan data');
        }

        $response = [
            'status' => 200,
            'error' => false,
            'messages' => 'Pembayaran berhasil, silakan menunggu verifikasi dari Bidang Keuangan',
        ];

        return $this->respond($response, 200);
    }

    public function history_pembayaran()
    {

        $max = 10;
        $page = 1;
        if ($this->request->getVar('max')) {
            $max = $this->request->getVar('max');
        }
        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        }

        $validation = [
            'nomor_anggota' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor anggota harus diisi'
                ]
            ],
        ];

        if (!$this->validate($validation)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $nomor_anggota = $this->request->getVar('nomor_anggota');

        $data = $this->data_anggota->select('nomor_anggota')->where('nomor_anggota', $nomor_anggota)->first();

        if (!$data) {
            return $this->failNotFound('Data anggota tidak ditemukan');
        }

        $history = $this->bayar_simwa->select('id_pembayaran, timestamp, nominal, status')
            ->where('nomor_anggota', $nomor_anggota)->findAll($max, ($page - 1) * $max);

        $response = [
            'status' => 200,
            'error' => false,
            'messages' => 'Berhasil mengambil data',
            'data' => ($history ? $history : []),
        ];

        return $this->respond($response, 200);
    }

    public function get_kegiatan()
    {
        $max = 10;
        $page = 1;
        if ($this->request->getVar('max')) {
            $max = $this->request->getVar('max');
        }
        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        }
        $kegiatan = $this->data_kegiatan->select('id_kegiatan, nama_kegiatan, tanggal_kegiatan, tempat_kegiatan')
            ->orderBy('tanggal_kegiatan', 'DESC')->where('tanggal_kegiatan>', Time::today('Asia/Jakarta'))->findAll($max, ($page - 1) * $max);

        if (!$kegiatan) {
            return $this->failNotFound('Data kegiatan tidak ditemukan');
        }

        $response = [
            'status' => 200,
            'error' => false,
            'messages' => 'Berhasil mengambil data',
            'data' => $kegiatan,
        ];

        return $this->respond($response, 200);
    }

    public function digilib()
    {
        $max = 10;
        $page = 1;
        if ($this->request->getVar('max')) {
            $max = $this->request->getVar('max');
        }
        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        }
        $digilib = $this->digilib->orderBy('id', 'DESC')->findAll($max, ($page - 1) * $max);

        if (!$digilib) {
            return $this->failNotFound('Data digilib tidak ditemukan');
        }

        foreach ($digilib as $key => $value) {
            $value->file = base_url('assets/uploads/document/digilib/' . $value->file);
        }

        $response = [
            'status' => 200,
            'error' => false,
            'messages' => 'Berhasil mengambil data',
            'data' => $digilib,
        ];

        return $this->respond($response, 200);
    }
}
