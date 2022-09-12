<?php

namespace App\Controllers;

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

use function bin2hex;
use function file_exists;
use function mkdir;

class Dashboard extends BaseController
{
    protected $data_anggota;
    protected $data_kegiatan;
    protected $data_simpanan;
    protected $calon_anggota;
    protected $data_poin;
    protected $jurusan;
    protected $referal;
    protected $bayar_simwa;
    protected $ciqrcode;
    protected $data_presensi;

    function __construct()
    {
        $this->data_anggota = new AnggotaModel();
        $this->data_kegiatan = new KegiatanModel();
        $this->data_simpanan = new SimpananModel();
        $this->calon_anggota = new CalonModel();
        $this->data_poin = new PoinModel();
        $this->jurusan = new JurusanModel();
        $this->referal = new ReferalModel();
        $this->bayar_simwa = new PembayaranSimwa();
        $this->ciqrcode = new Ciqrcode();
        $this->data_presensi = new Presensi();
    }

    public function index()
    {
        $anggota = $this->data_anggota->findAll();

        $data = [
            'title' => 'Data Anggota',
            'anggota' => $anggota
        ];
        return view('dashboard/data_anggota', $data);
    }
    public function data_anggota()
    {
        $anggota = $this->data_anggota->findAll();
        $data = [
            'title' => 'Data Anggota',
            'anggota' => $anggota
        ];
        return view('dashboard/data_anggota', $data);
    }
    public function data_poin()
    {
        $poin = $this->data_poin->getPoin();
        $data = [
            'title' => 'Data Poin',
            'data' => $poin
        ];
        return view('dashboard/data_poin', $data);
    }

    public function data_simpanan()
    {
        $simpanan = $this->data_simpanan->getSimpanan();
        $data = [
            'title' => 'Data Simpanan',
            'simpanan' => $simpanan
        ];
        return view('dashboard/data_simpanan', $data);
    }

    public function data_kegiatan()
    {
        $data = [
            'title' => 'Data Kegiatan',
            'kegiatan' => $this->data_kegiatan->getKegiatan()
        ];
        return view('dashboard/data_kegiatan', $data);
    }
    public function presensi($id)
    {

        $data = [
            'title' => 'Presensi',
            'data' => $this->data_presensi->getPresensi($id),
            'kegiatan' => $this->data_kegiatan->getKegiatan($id)
        ];
        return view('dashboard/presensi', $data);
    }

    public function calon_anggota()
    {
        $calon = $this->calon_anggota->getCalonAnggota();
        $data = [
            'title' => 'Calon Anggota',
            'calon_anggota' => $calon
        ];
        return view('dashboard/calon_anggota', $data);
    }

    public function add_anggota()
    {
        $jur = $this->jurusan->findAll();
        $data = [
            'title' => 'Tambah Data Anggota',
            'jurusan' => $jur
        ];
        return view('dashboard/add_anggota', $data);
    }

    public function save_anggota()
    {
        $this->data_anggota->save([
            'npm' => $this->request->getVar('npm'),
            'nomor_anggota' => $this->request->getVar('nomor_anggota'),
            'nama_lengkap' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
            'nomor_hp' => $this->request->getVar('no_handphone'),
            'id_jurusan' => $this->request->getVar('jurusan')
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        return redirect()->to('/dashboard/add_anggota');
    }

    public function add_kegiatan()
    {
        $data = [
            'title' => 'Tambah Data Kegiatan'
        ];
        return view('dashboard/add_kegiatan', $data);
    }

    public function save_kegiatan()
    {
        $id = random_int(1000, 9999);
        $this->data_kegiatan->save([
            'id_kegiatan' => $id,
            'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
            'tanggal_kegiatan' => $this->request->getVar('tanggal'),
            'tempat_kegiatan' => $this->request->getVar('tempat'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        return redirect()->to('/dashboard/add_kegiatan');
    }

    public function kode_referal()
    {
        $ref = $this->referal->getReferal();
        $data = [
            'title' => 'Kode Referal',
            'referal' => $ref
        ];
        return view('dashboard/kode_referal', $data);
    }

    public function pembayaran_simwa()
    {
        $simwa = $this->bayar_simwa->getPembayaran();
        $data = [
            'title' => 'Pembayaran Simpanan Wajib',
            'simwa' => $simwa
        ];
        return view('dashboard/pembayaran_simwa', $data);
    }

    public function qr_code($id)
    {
        $save_name = $id . '.png';
        $dir = 'assets/media/qrcode/';
        if (!file_exists($dir)) {
            mkdir($dir, 0775, true);
        }

        /* QR Configuration  */
        $config['cacheable']    = true;
        $config['imagedir']     = $dir;
        $config['quality']      = true;
        $config['size']         = '1024';
        $config['black']        = [255, 255, 255];
        $config['white']        = [255, 255, 255];
        $this->ciqrcode->initialize($config);

        $params['data']     = $id;
        $params['level']    = 'L';
        $params['size']     = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . $save_name;

        $this->ciqrcode->generate($params);

        $data = [
            'title' => 'QR Code',
            'kegiatan' => $this->data_kegiatan->getKegiatan($id),
            'file'    => $dir . $save_name
        ];
        return view('dashboard/qr_code', $data);
    }

    public function qr_download($file_name)
    {
        $dir = "assets/media/qrcode/";
        $file = $dir . $file_name;
        $ctype = "application/octet-stream";
        if (!empty($file) && file_exists($file)) { /*check keberadaan file*/
            header("Pragma:public");
            header("Expired:0");
            header("Cache-Control:must-revalidate");
            header("Content-Control:public");
            header("Content-Description: File Transfer");
            header("Content-Type: $ctype");
            header("Content-Disposition:attachment; filename=\"" . $file . "\";");
            header("Content-Transfer-Encoding:binary");
            header("Content-Length:" . filesize($file));
            flush();
            readfile($file);
            exit();
        } else {
            echo "File tidak ditemukan";
        }
    }

    public function add_referal()
    {
        $data = [
            'title' => 'Tambah Kode Referal'
        ];
        return view('dashboard/add_referal', $data);
    }

    public function save_referal()
    {
        // dd($this->request->getVar());
        $this->referal->save([
            'kode_referal' => $this->request->getVar('referal'),
            'nomor_anggota' => $this->request->getVar('nomor_anggota'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        return redirect()->to('/dashboard/add_referal');
    }

    public function add_simpanan($npm)
    {
        $nama = $this->data_anggota->select('nama_lengkap')->where('npm', $npm)
            ->first();
        $data = [
            'title' => 'Tambah Simpanan',
            'npm' => $npm,
            'nama' => $nama
        ];
        return view('dashboard/add_simpanan', $data);
    }

    public function save_simpanan(){
        
    }
}
