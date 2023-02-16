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
use App\Models\SiJukoAccount;
use Kenjis\CI3Compatible\Core\CI_Input;
use CodeIgniter\I18n\Time;
use CodeIgniter\Validation\Validation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;
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
    protected $akun_juko;

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
        $this->akun_juko = new SiJukoAccount();
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
            $anggota = $this->data_anggota
                ->like('data_anggota.npm', $search)->orLike('data_anggota.nama_lengkap', $search)
                ->orLike('data_anggota.nomor_anggota', $search)
                ->paginate(50, 'data_anggota');
        } else {
            $anggota = $this->data_anggota->paginate(50, 'data_anggota');
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

        // $jur = $this->jurusan->findAll();
        $data = [
            'title' => 'Tambah Data Anggota',
            // 'jurusan' => $jur,
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
            'jenis_kelamin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis Kelamin harus diisi'
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
            'status_keanggotaan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harus Diisi'
                ]
            ],
            'jurusan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jurusan harus diisi'
                ]
            ],
            'fakultas' => [
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
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'nama_lengkap' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
            'nomor_hp' => $this->request->getVar('no_handphone'),
            'keanggotaan'   => $this->request->getVar('status_keanggotaan'),
            'jurusan' => $this->request->getVar('jurusan'),
            'fakultas'  => $this->request->getVar('fakultas'),
        ];
        $referal = strtoupper(substr($save['nama_lengkap'], 0, 3) . substr($save['nomor_anggota'], 0, 4));

        if ($this->data_anggota->insert($save, false)) {

            $status = true;
            if ($this->data_poin->insert([
                'nomor_anggota' => $save['nomor_anggota'],
                'poin' => 0
            ], false)) {

                if ($this->simpanan->insert([
                    'simpanan_pokok' => 0,
                    'simpanan_wajib' => 0,
                    'nomor_anggota' => $save['nomor_anggota'],
                ], false)) {
                    if (!$this->referal->insert([
                        'nomor_anggota' => $save['nomor_anggota'],
                        'kode_referal' => $referal,
                    ], false)) {

                        $this->data_poin->where('nomor_anggota', $save['nomor_anggota'])->delete();
                        $this->simpanan->where('nomor_anggota', $save['nomor_anggota'])->delete();
                        $this->data_anggota->where('nomor_anggota', $save['nomor_anggota'])->delete();
                        dd('gagal');
                        $status = false;
                    }
                } else {
                    $this->data_poin->where('nomor_anggota', $save['nomor_anggota'])->delete();
                    $this->data_anggota->where('nomor_anggota', $save['nomor_anggota'])->delete();
                    $status = false;
                }
            } else {
                $this->data_anggota->where('nomor_anggota', $save['nomor_anggota'])->delete();
                // dd('gagal');
                $status = false;
            }

            if (!$status) {
                session()->setFlashdata('pesan', 'Data gagal ditambahkan');
                return redirect()->to('/psda/data_anggota');
            }
        }

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        return redirect()->to('/psda/data_anggota');
    }

    public function delete_anggota()
    {
        $nomor_anggota = $this->request->getVar('nomor_anggota');

        $this->data_presensi->where('id_data', $nomor_anggota)->delete();
        $this->data_poin->where('nomor_anggota', $nomor_anggota)->delete();
        $this->simpanan->where('nomor_anggota', $nomor_anggota)->delete();
        $this->referal->where('nomor_anggota', $nomor_anggota)->delete();
        $this->data_anggota->where('nomor_anggota', $nomor_anggota)->delete();

        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/psda/data_anggota');
    }

    public function edit_anggota()
    {
        $nomor_anggota = $this->request->getVar('nomor_anggota');
        $data = [
            'title' => 'Edit Data Anggota',
            'anggota' => $this->data_anggota->where('nomor_anggota', $nomor_anggota)->first(),
            'validation' => \Config\Services::validation(),
        ];
        return view('/psda/edit_anggota', $data);
    }

    public function update_anggota()
    {

        if (!$this->data_anggota->save([
            'npm' => $this->request->getVar('npm'),
            'nomor_anggota' => $this->request->getVar('nomor_anggota'),
            'nama_lengkap' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
            'nomor_hp' => $this->request->getVar('no_handphone'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'keanggotaan' => $this->request->getVar('keanggotaan'),
            'jurusan' => $this->request->getVar('jurusan'),
            'fakultas' => $this->request->getVar('fakultas'),
        ])) {
            session()->setFlashdata('error', 'Data gagal diudpate');
            return redirect()->to('/psda/data_anggota');
        }
        session()->setFlashdata('success', 'Data berhasil diudpate');
        return redirect()->to('/psda/data_anggota');
    }

    public function upload_calon_anggota()
    {
        // dd($this->request->getVar());
        $file = $this->request->getFile('csv');
        // dd($file);
        if ($file->getExtension() == 'xlsx') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        } else if ($file->getExtension() == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        }

        $spreadsheet = $reader->load($file);
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->removeRow(1);
        $spreadsheet = $spreadsheet->getActiveSheet()->toArray();

        foreach ($spreadsheet as $s) {
            $save = [
                'npm'               => $s[0],
                'nama_lengkap'      => $s[1],
                'nama_panggilan'    => $s[2],
                'jurusan'           => $s[3],
                'fakultas'          => $s[4],
                'nomor_hp'          => $s[5],
                'email'             => $s[6],
                'asal_informasi'    => $s[7],
                'domisili'          => $s[8],
                'alasan'            => $s[9],
                'kode_referal'      => $s[10],
            ];


            if (!$this->calon_anggota->insert($save, false)) {




                session()->setFlashdata('error', 'Data gagal ditambahkan');
                return redirect()->to('/psda/calon_anggota');
            }
        }

        session()->setFlashdata('success', 'Data berhasil diupload');
        return redirect()->to('/psda/calon_anggota');
    }


    public function upload_anggota()
    {
        $file = $this->request->getFile('csv');
        if ($file->getExtension() == 'xlsx') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        } else if ($file->getExtension() == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        }

        $spreadsheet = $reader->load($file);
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->removeRow(1);
        $spreadsheet = $spreadsheet->getActiveSheet()->toArray();

        foreach ($spreadsheet as $s) {
            $save = [
                'nomor_anggota' => $s[0],
                'npm'           => $s[1],
                'nama_lengkap'  => $s[2],
                'email'         => $s[3],
                'jenis_kelamin' => $s[4],
                'nomor_hp'      => $s[5],
                'tgl_diksar'    => $s[6],
                'keanggotaan'   => $s[7],
                'jurusan'       => $s[8],
                'fakultas'      => $s[9],
            ];

            $referal = strtoupper(substr($save['nama_lengkap'], 0, 3) . substr($save['nomor_anggota'], 0, 4));

            if ($this->data_anggota->insert($save, false)) {

                $status = true;
                if ($this->data_poin->insert([
                    'nomor_anggota' => $save['nomor_anggota'],
                    'poin' => 0
                ], false)) {

                    if ($this->simpanan->insert([
                        'simpanan_pokok' => 0,
                        'simpanan_wajib' => 0,
                        'nomor_anggota' => $save['nomor_anggota'],
                    ], false)) {
                        if (!$this->referal->insert([
                            'nomor_anggota' => $save['nomor_anggota'],
                            'kode_referal' => $referal,
                        ], false)) {

                            $this->data_poin->where('nomor_anggota', $save['nomor_anggota'])->delete();
                            $this->simpanan->where('nomor_anggota', $save['nomor_anggota'])->delete();
                            $this->data_anggota->where('nomor_anggota', $save['nomor_anggota'])->delete();
                            dd('gagal');
                            $status = false;
                        }
                    } else {
                        $this->data_poin->where('nomor_anggota', $save['nomor_anggota'])->delete();
                        $this->data_anggota->where('nomor_anggota', $save['nomor_anggota'])->delete();
                        $status = false;
                    }
                } else {
                    $this->data_anggota->where('nomor_anggota', $save['nomor_anggota'])->delete();
                    // dd('gagal');
                    $status = false;
                }

                if (!$status) {
                    session()->setFlashdata('pesan', 'Data gagal ditambahkan');
                    return redirect()->to('/psda/data_anggota');
                }
            }
        }

        session()->setFlashdata('pesan', 'Data berhasil diupload');
        return redirect()->to('/psda/data_anggota');
    }
    // End of Anggota Function

    // Calon Anggota Function
    public function calon_anggota()
    {
        // dd($this->calon_anggota);
        $search = $this->request->getVar('search');
        if ($search) {
            $calon = $this->calon_anggota
                ->like('calon_anggota.npm', $search)
                ->orLike('calon_anggota.nama_lengkap', $search)
                ->orLike('calon_anggota.jurusan', $search)
                ->orlike('calon_anggota.fakultas', $search)
                ->paginate(25, 'calon_anggota');
        } else {
            $calon = $this->calon_anggota->paginate(25, 'calon_anggota');
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

        $calon = $this->calon_anggota->findAll();

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
        $sheet->setCellValue('M1', 'Jenis Kelamin');
        $sheet->setCellValue('N1', 'Alasan Masuk Kopma');
        $sheet->setCellValue('O1', 'Kode Referal');
        $row = 2;

        foreach ($calon as $c) {
            $sheet->setCellValue('A' . $row, $row - 1);
            $sheet->setCellValue('B' . $row, $c['npm']);
            $sheet->setCellValue('C' . $row, $c['nama_lengkap']);
            $sheet->setCellValue('D' . $row, $c['nama_panggilan']);
            $sheet->setCellValue('E' . $row, $c['jurusan']);
            $sheet->setCellValue('F' . $row, $c['fakultas']);
            $sheet->setCellValue('G' . $row, $c['nomor_hp']);
            $sheet->setCellValue('H' . $row, $c['email']);
            $sheet->setCellValue('I' . $row, $c['asal_informasi']);
            $sheet->setCellValue('J' . $row, $c['domisili']);
            $sheet->setCellValue('K' . $row, $c['tempat_lahir']);
            $sheet->setCellValue('L' . $row, $c['tanggal_lahir']);
            $sheet->setCellValue('M' . $row, $c['jenis_kelamin']);
            $sheet->setCellValue('N' . $row, $c['alasan']);
            $sheet->setCellValue('O' . $row, $c['referal']);
            $row++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('assets/download/document/' . $filename);
        $file = 'assets/download/document/' . $filename;
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

    public function reset_calon()
    {
        $input = $this->request->getVar();
        if ($input['confirm'] != $input['random']) {
            session()->setFlashData('error', 'Kata tidak sama!');
            return redirect()->to('psda/calon_anggota');
        }
        $query = "DELETE FROM calon_anggota";
        $db = db_connect();


        if (!$db->query($query)) {
            session()->setFlashdata('error', 'Reset data gagal dilakukan!');
            return redirect()->to('psda/calon_anggota');
        }

        session()->setFlashData('success', 'Reset data berhasil dilakukan');
        return redirect()->to('psda/calon_anggota');
    }
    // End of Calon Anggota Function 

    // Poin Function
    public function data_poin()
    {
        $search = $this->request->getVar('search');
        if ($search) {
            $poin = $this->data_poin->join('data_anggota', 'data_anggota.nomor_anggota=data_poin.nomor_anggota')
                ->join('data_simpanan', 'data_simpanan.nomor_anggota=data_anggota.nomor_anggota')
                ->select('data_poin.poin, data_anggota.nomor_anggota, data_anggota.nama_lengkap, data_anggota.nomor_anggota, data_simpanan.simpanan_wajib')
                ->like('data_anggota.nama_lengkap', $search)->orLike('data_poin.nomor_anggota', $search)->findAll();
        } else {
            $poin = $this->data_poin->getPoin();
        }
        $data = [
            'title' => 'Data Poin',
            'data' => $poin
        ];
        return view('psda/data_poin', $data);
    }

    public function download_poin()
    {
        $ref = $this->data_poin->getPoin();


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Nama Lengkap');
        $sheet->setCellValue('B1', 'Nomor Anggota');
        $sheet->setCellValue('C1', 'Poin');
        $i = 2;
        foreach ($ref as $r) {
            $sheet->setCellValue('A' . $i, $r['nama_lengkap']);
            $sheet->setCellValue('B' . $i, $r['nomor_anggota']);
            $sheet->setCellValue('C' . $i, $r['poin'] + (int) (($r['simpanan_wajib'] / 10000) * 3));
            $i++;
        }

        $filename = 'poin.xlsx';

        $writer = new Xlsx($spreadsheet);
        $writer->save('assets/download/document/' . $filename);
        $file = 'assets/download/document/' . $filename;
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

    public function upload_poin()
    {
        $validation = [
            'file'  => [
                'rules' => 'uploaded[file]|ext_in[file,xls,xlsx]',
                'errors' => [
                    'uploaded' => 'Pilih file terlebih dahulu',
                    'ext_in' => 'File yang diupload harus berupa xls atau xlsx'
                ]
            ]
        ];

        if (!$this->validate($validation)) {
            session()->setFlashdata('pesan', $this->validator->listErrors());
            return redirect()->to('/psda/data_poin');
        }

        $file = $this->request->getFile('file');

        if ($file->getExtension() == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else if ($file->getExtension() == 'xlsx') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        } else {
            session()->setFlashdata('pesan', 'File yang diupload harus berupa xls atau xlsx');
            return redirect()->to('/psda/data_poin');
        }

        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->removeRow(1);
        $data = $sheet->toArray();
        foreach ($data as $d) {

            $poin = $this->data_poin->select('poin')->where('nomor_anggota', $d[0])->first();

            if (!$this->data_poin->save([
                'nomor_anggota' => $d[0],
                'poin' => $poin['poin'] + $d[2],
            ])) {
                session()->setFlashdata('pesan', 'Kesalahan pada data ' . $d[1] . ' diupload');
                return redirect()->to('/psda/data_poin');
            }
        }
        session()->setFlashdata('pesan', 'Data poin berhasil diupload');
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

    public function download_referal()
    {
        $ref = $this->referal->select('data_anggota.nama_lengkap, data_anggota.nomor_anggota, referal.kode_referal')
            ->selectCount('calon_anggota.kode_referal', 'jumlah')
            ->join('data_anggota', 'data_anggota.nomor_anggota=referal.nomor_anggota')
            ->join('calon_anggota', 'calon_anggota.kode_referal=referal.kode_referal', 'left')
            ->groupBy('referal.kode_referal')
            ->findAll();


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Nama Lengkap');
        $sheet->setCellValue('B1', 'Nomor Anggota');
        $sheet->setCellValue('C1', 'Kode Referal');
        $sheet->setCellValue('D1', 'Jumlah');
        $i = 2;
        foreach ($ref as $r) {
            $sheet->setCellValue('A' . $i, $r['nama_lengkap']);
            $sheet->setCellValue('B' . $i, $r['nomor_anggota']);
            $sheet->setCellValue('C' . $i, $r['kode_referal']);
            $sheet->setCellValue('D' . $i, $r['jumlah']);
            $i++;
        }

        $filename = 'kode_referal.xlsx';

        $writer = new Xlsx($spreadsheet);
        $writer->save('assets/download/document/' . $filename);
        $file = 'assets/download/document/' . $filename;
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
    // End of Referal Function
}
