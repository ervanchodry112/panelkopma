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

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
    protected $simpanan;

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
        $this->simpanan = new SimpananModel();
    }

    public function index()
    {
        return redirect()->to('/psda/data_anggota');
    }

    // Data Anggota
    public function data_anggota()
    {
        //select all data with chunk
        $search = $this->request->getVar('search');
        if ($search) {
            $anggota = $this->data_anggota->join('jurusan', 'jurusan.id_jurusan = data_anggota.id_jurusan')
                ->like('data_anggota.npm', $search)->orLike('data_anggota.nama_lengkap', $search)
                ->orLike('data_anggota.nomor_anggota', $search)
                ->paginate(25, 'data_anggota');
        } else {
            $anggota = $this->data_anggota->join('jurusan', 'jurusan.id_jurusan = data_anggota.id_jurusan')->paginate(50, 'data_anggota');
        }


        $cur_page = $this->request->getVar('page_data_anggota') ? $this->request->getVar('page_data_anggota') : 1;
        $data = [
            'title' => 'Data Anggota',
            'anggota' => $anggota,
            'pager' => $this->data_anggota->pager,
            'currentPage' => $cur_page,
        ];
        return view('psda/data_anggota', $data);
    }

    public function add_anggota()
    {

        $jur = $this->jurusan->findAll();
        $data = [
            'title' => 'Tambah Data Anggota',
            'jurusan' => $jur,
            'validation' => \Config\Services::validation()
        ];
        return view('psda/add_anggota', $data);
    }

    public function save_anggota()
    {
        if (!$this->validate([
            'npm' => [
                'rules' => 'required|is_unique[data_anggota.npm]',
                'errors' => [
                    'required' => 'NPM harus diisi',
                    'is_unique' => 'NPM sudah terdaftar'
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi'
                ]
            ],
            'nomor_anggota' => [
                'rules' => 'required|is_unique[data_anggota.nomor_anggota]|min_length[16]|max_length[16]',
                'errors' => [
                    'required' => 'Nomor Anggota harus diisi',
                    'is_unique' => 'Nomor Anggota sudah terdaftar',
                    'min_length' => 'Nomor anggota harus 16 karakter',
                    'max_length' => 'Nomor anggota harus 16 karakter'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Email tidak valid',
                ]
            ],
            'no_handphone' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'No Handphone harus diisi',
                    'numeric' => 'No Handphone harus angka'
                ]
            ],
            'jurusan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jurusan harus diisi'
                ]
            ],
        ])) {
            return redirect()->to('/psda/add_anggota')->withInput();
        }

        $save = [
            'npm' => $this->request->getVar('npm'),
            'nomor_anggota' => $this->request->getVar('nomor_anggota'),
            'nama_lengkap' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
            'nomor_hp' => $this->request->getVar('no_handphone'),
            'id_jurusan' => $this->request->getVar('jurusan')
        ];

        if ($this->data_anggota->insert($save)) {
            $status = true;
            if (!$this->data_poin->insert([
                'nomor_anggota' => $this->request->getVar('nomor_anggota'),
                'poin' => 0
            ])) {
                $this->data_anggota->delete($this->request->getVar('npm'));
                $status = false;
            }

            if (!$this->simpanan->insert([
                'simpanan_pokok' => 0,
                'simpanan_wajib' => 0,
                'total_simpanan' => 0,
                'npm'   => $this->request->getVar('npm'),
                'nomor_anggota' => $this->request->getVar('nomor_anggota'),
            ])) {
                $this->data_anggota->delete($this->request->getVar('npm'));
                $this->data_poin->delete($this->request->getVar('nomor_anggota'));
                $status = false;
            }

            if (!$this->referal->insert([
                'nomor_anggota' => $this->request->getVar('nomor_anggota'),
                'referal' => substr($this->request->getVar('nama'), 0, 3) . substr($this->request->getVar('nomor_anggota'), 0, 4),
            ])) {
                $this->data_anggota->delete($this->request->getVar('npm'));
                $this->data_poin->delete($this->request->getVar('nomor_anggota'));
                $this->simpanan->delete($this->request->getVar('nomor_anggota'));
                $status = false;
            }

            if (!$status) {
                session()->setFlashdata('pesan', 'Data gagal ditambahkan');
                return redirect()->to('/psda/add_anggota');
            }
        }

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        return redirect()->to('/psda/data_anggota');
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
        $search = $this->request->getVar('search');
        if ($search) {
            $calon = $this->calon_anggota->join('jurusan', 'calon_anggota.id_jurusan=jurusan.id_jurusan')
                ->join('fakultas', 'jurusan.id_fakultas=fakultas.id_fakultas')
                ->like('calon_anggota.npm', $search)
                ->orLike('calon_anggota.nama_lengkap', $search)
                ->orLike('jurusan.nama_jurusan', $search)
                ->orlike('fakultas.nama_fakultas', $search)
                ->paginate(25, 'calon_anggota');
        } else {
            $calon = $this->calon_anggota->join('jurusan', 'calon_anggota.id_jurusan=jurusan.id_jurusan')
                ->join('fakultas', 'jurusan.id_fakultas=fakultas.id_fakultas')
                ->paginate(25, 'calon_anggota');
        }
        $cur_page = $this->request->getVar('page_calon_anggota') ? $this->request->getVar('page_calon_anggota') : 1;
        $data = [
            'title' => 'Calon Anggota',
            'calon_anggota' => $calon,
            'pager' => $this->calon_anggota->pager,
            'current_page' => $cur_page,
        ];
        return view('psda/calon_anggota', $data);
    }

    public function delete_calon($npm)
    {
        $this->calon_anggota->delete($npm);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/psda/calon_anggota');
    }

    public function download_calon()
    {
        $filename = 'calon_anggota.xlsx';
        $spreadsheet = new Spreadsheet();

        $calon = $this->calon_anggota->getCalonAnggota();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'NPM');
        $sheet->setCellValue('C1', 'Nama Lengkap');
        $sheet->setCellValue('D1', 'Panggilan');
        $sheet->setCellValue('E1', 'Jurusan');
        $sheet->setCellValue('F1', 'Fakultas');
        $sheet->setCellValue('G1', 'Nomor Whatsapp');
        $sheet->setCellValue('H1', 'Email');
        $sheet->setCellValue('I1', 'Asal Informasi');
        $sheet->setCellValue('J1', 'Domisili');
        $sheet->setCellValue('K1', 'Tempat Lahir');
        $sheet->setCellValue('L1', 'Tanggal Lahir');
        $sheet->setCellValue('M1', 'Alasan Masuk Kopma');
        $sheet->setCellValue('N1', 'Kode Referal');
        $row = 2;

        foreach ($calon as $c) {
            $sheet->setCellValue('A' . $row, $row - 1);
            $sheet->setCellValue('B' . $row, $c['npm']);
            $sheet->setCellValue('C' . $row, $c['nama_lengkap']);
            $sheet->setCellValue('D' . $row, $c['nama_panggilan']);
            $sheet->setCellValue('E' . $row, $c['nama_jurusan']);
            $sheet->setCellValue('F' . $row, $c['nama_fakultas']);
            $sheet->setCellValue('G' . $row, $c['nomor_hp']);
            $sheet->setCellValue('H' . $row, $c['email']);
            $sheet->setCellValue('I' . $row, $c['asal_informasi']);
            $sheet->setCellValue('J' . $row, $c['domisili']);
            $sheet->setCellValue('K' . $row, $c['tempat_lahir']);
            $sheet->setCellValue('L' . $row, $c['tanggal_lahir']);
            $sheet->setCellValue('M' . $row, $c['alasan']);
            $sheet->setCellValue('N' . $row, $c['kode_referal']);
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('assets/document/' . $filename);
        $file = 'assets/document/' . $filename;
        header("Content-Type: application/vnd.ms-excel");

        header('Content-Disposition: attachment; filename="' . basename($file) . '"');

        header('Expires: 0');

        header('Cache-Control: must-revalidate');

        header('Pragma: public');

        header('Content-Length:' . filesize($file));

        flush();

        readfile($file);

        exit;
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
        $search = $this->request->getVar('search');

        if ($search != null) {
            $ref = $this->referal->select('*')->selectCount('calon_anggota.kode_referal', 'jumlah')
                ->like('data_anggota.nama_lengkap', $search)
                ->orLike('referal.kode_referal', $search)
                ->orLike('data_anggota.nomor_anggota', $search)
                ->join('calon_anggota', 'calon_anggota.kode_referal=referal.kode_referal')
                ->join('data_anggota', 'data_anggota.nomor_anggota=referal.nomor_anggota')
                ->groupBy('referal.kode_referal')
                ->findAll();
        } else {
            $ref = $this->referal->select('data_anggota.nama_lengkap, data_anggota.nomor_anggota, referal.kode_referal')
                ->selectCount('calon_anggota.kode_referal', 'jumlah')
                ->join('data_anggota', 'data_anggota.nomor_anggota=referal.nomor_anggota')
                ->join('calon_anggota', 'calon_anggota.kode_referal=referal.kode_referal', 'left')
                ->groupBy('referal.kode_referal')
                ->findAll();
        }
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
