<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\AnggotaModel;
use App\Models\CalonModel;
use App\Models\FakultasModel;
use App\Models\JurusanModel;
use App\Models\KegiatanModel;
use App\Models\PembayaranSimwa;
use App\Models\PoinModel;
use App\Models\ReferalModel;
use App\Models\SimpananModel;
use App\Models\Presensi;

use App\Libraries\Ciqrcode;
use App\Models\Home_model;
use Kenjis\CI3Compatible\Core\CI_Input;
use CodeIgniter\I18n\Time;

use function bin2hex;
use function file_exists;
use function mkdir;

class Psda extends BaseController
{
    protected $data_anggota;
    protected $data_kegiatan;
    protected $calon_anggota;
    protected $data_poin;
    protected $jurusan;
    protected $referal;
    protected $ciqrcode;
    protected $data_presensi;

    public function __construct()
    {
        $this->data_anggota = new AnggotaModel();
        $this->data_kegiatan = new KegiatanModel();
        $this->calon_anggota = new CalonModel();
        $this->data_poin = new PoinModel();
        $this->jurusan = new JurusanModel();
        $this->referal = new ReferalModel();
        $this->ciqrcode = new Ciqrcode();
        $this->data_presensi = new Presensi();
    }

    public function index()
    {
        return redirect()->to('/psda/data_anggota');
    }

    // Data Anggota
    public function data_anggota()
    {
        $anggota = $this->data_anggota->join('jurusan', 'jurusan.id_jurusan = data_anggota.id_jurusan')->findAll();
        $data = [
            'title' => 'Data Anggota',
            'anggota' => $anggota,
        ];
        return view('psda/data_anggota', $data);
    }

    public function add_anggota()
    {
        $jur = $this->jurusan->findAll();
        $data = [
            'title' => 'Tambah Data Anggota',
            'jurusan' => $jur
        ];
        return view('psda/add_anggota', $data);
    }

    public function save_anggota()
    {
        $this->data_anggota->insert([
            'npm' => $this->request->getVar('npm'),
            'nomor_anggota' => $this->request->getVar('nomor_anggota'),
            'nama_lengkap' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
            'nomor_hp' => $this->request->getVar('no_handphone'),
            'id_jurusan' => $this->request->getVar('jurusan')
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        return redirect()->to('/psda/add_anggota');
    }

    public function delete_anggota($npm)
    {
        $this->data_anggota->delete($npm);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/psda/data_anggota');
    }

    public function edit_anggota($npm)
    {
        $jur = $this->jurusan->findAll();
        $data = [
            'title' => 'Edit Data Anggota',
            'anggota' => $this->data_anggota->where('data_anggota.npm', $npm)->join('jurusan', 'jurusan.id_jurusan=data_anggota.id_jurusan')->first(),
            'jurusan' => $jur,
        ];
        return view('/psda/edit_anggota', $data);
    }

    public function update_anggota()
    {
        $this->data_anggota->save([
            'npm' => $this->request->getVar('npm'),
            'nomor_anggota' => $this->request->getVar('nomor_anggota'),
            'nama_lengkap' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
            'nomor_hp' => $this->request->getVar('no_handphone'),
            'id_jurusan' => $this->request->getVar('jurusan')
        ]);
        session()->setFlashdata('pesan', 'Data berhasil diudpate');
        return redirect()->to('/psda/data_anggota');
    }
    // End of Anggota Function

    // Calon Anggota Function
    public function calon_anggota()
    {
        $calon = $this->calon_anggota->getCalonAnggota();
        $data = [
            'title' => 'Calon Anggota',
            'calon_anggota' => $calon
        ];
        return view('psda/calon_anggota', $data);
    }

    public function delete_calon($npm)
    {
        $this->calon_anggota->delete($npm);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/psda/calon_anggota');
    }

    // End of Calon Anggota Function 

    // Poin Function
    public function data_poin()
    {
        $poin = $this->data_poin->getPoin();
        $data = [
            'title' => 'Data Poin',
            'data' => $poin
        ];
        return view('psda/data_poin', $data);
    }

    public function add_value($seg1, $seg2, $seg3)
    {
        $nomor_anggota = $seg1 . '/' . $seg2 . '/' . $seg3;
        $anggota = $this->data_anggota->join('data_poin', 'data_anggota.nomor_anggota=data_poin.nomor_anggota')
            ->select('data_anggota.nama_lengkap, data_poin.nomor_anggota')->where('data_anggota.nomor_anggota', $nomor_anggota)
            ->first();

        $data = [
            'title' => 'Tambah Poin',
            'anggota' => $anggota,
        ];
        return view('psda/add_value', $data);
    }

    public function sum_value()
    {
        $poin_lama = $this->data_poin->select('poin')->where('nomor_anggota', $this->request->getVar('nomor_anggota'))->first();
        $poin = $poin_lama['poin'] + $this->request->getVar('poin');
        // dd($poin);
        $this->data_poin->save([
            'poin' => $poin,
            'nomor_anggota' => $this->request->getVar('nomor_anggota'),
        ]);
        session()->setFlashdata('pesan', 'Poin berhasil ditambah');
        return redirect()->to('/psda/data_poin');
    }
    // End of Poin Function

    // Referal Function
    public function kode_referal()
    {
        $ref = $this->referal->getReferal();
        // dd($ref);
        $data = [
            'title' => 'Kode Referal',
            'referal' => $ref
        ];
        return view('psda/kode_referal', $data);
    }

    public function add_referal()
    {
        $data = [
            'title' => 'Tambah Kode Referal'
        ];
        return view('psda/add_referal', $data);
    }

    public function save_referal()
    {
        // dd($this->request->getVar());
        $this->referal->insert([
            'kode_referal' => $this->request->getVar('referal'),
            'nomor_anggota' => $this->request->getVar('nomor_anggota'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        return redirect()->to('/psda/add_referal');
    }

    public function delete_referal($seg1 = false, $seg2 = false, $seg3 = false)
    {
        $nomor_anggota = $seg1 . "/" . $seg2 . "/" . $seg3;
        // dd($nomor_anggota);
        $this->referal->delete($nomor_anggota);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/psda/kode_referal');
    }
    // End of Referal Function
}
