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
use App\Models\ProgramKerja;
use Kenjis\CI3Compatible\Core\CI_Input;
use CodeIgniter\I18n\Time;
use DateTime;
use Myth\Auth\Models\UserModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use function bin2hex;
use function file_exists;
use function mkdir;

class Dashboard extends BaseController
{
    protected $data_kegiatan;
    protected $data_presensi;
    protected $ciqrcode;
    protected $data_user;
    protected $auth;
    protected $progja;

    function __construct()
    {
        $this->data_kegiatan = new KegiatanModel();
        $this->data_presensi = new Presensi();
        $this->ciqrcode = new Ciqrcode();
        $this->data_user = new UserModel();
        $this->auth   = service('authentication');
        $this->progja = new ProgramKerja();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
        ];

        return view('dashboard/index', $data);
    }

    // Kegiatan Function
    public function data_kegiatan()
    {
        $data = [
            'title' => 'Data Kegiatan',
            'kegiatan' => $this->data_kegiatan->getKegiatan()
        ];
        return view('dashboard/data_kegiatan', $data);
    }

    public function add_kegiatan()
    {
        $data = [
            'title' => 'Tambah Data Kegiatan'
        ];
        return view('dashboard/add_kegiatan', $data);
    }

    public function edit_kegiatan($id)
    {
        $data = [
            'title' => 'Edit Data Kegiatan',
            'kegiatan' => $this->data_kegiatan->getKegiatan($id)
        ];
        return view('dashboard/edit_kegiatan', $data);
    }

    public function save_kegiatan()
    {
        $id = random_int(1000, 9999);
        $data = [
            'id_kegiatan' => $id,
            'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
            'tanggal_kegiatan' => $this->request->getVar('tanggal'),
            'tempat_kegiatan' => $this->request->getVar('tempat'),
        ];
        if (!$this->data_kegiatan->save($data)) {
            session()->setFlashdata('error', 'Gagal Menambahkan Data');
        }

        session()->setFlashdata('success', 'Data berhasil ditambahkan');

        return redirect()->to('/dashboard/data_kegiatan');
    }

    public function update_kegiatan()
    {
        $this->data_kegiatan->save([
            'id_kegiatan' => $this->request->getVar('id_kegiatan'),
            'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
            'tanggal_kegiatan' => $this->request->getVar('tanggal'),
            'tempat_kegiatan' => $this->request->getVar('tempat'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        return redirect()->to('/dashboard/data_kegiatan');
    }

    public function presensi($id)
    {
        $presensi = $this->data_presensi->join('data_anggota', 'data_anggota.npm=presensi.id_data')
            ->join('data_kegiatan', 'data_kegiatan.id_kegiatan=presensi.id_kegiatan')
            ->where('presensi.id_kegiatan', $id)->paginate(25, 'presensi');

        $kegiatan = $this->data_kegiatan->getKegiatan($id);

        $tgl_kegiatan = new DateTime($kegiatan['tanggal_kegiatan']);
        $today = new DateTime();

        if ($tgl_kegiatan < $today) {
            $status = 'Selesai';
        } else {
            $status = 'Belum Selesai';
        }

        $current_page = $this->request->getVar('page_presensi') ? $this->request->getVar('page_presensi') : 1;
        $data = [
            'title' => 'Presensi',
            'data' => $presensi,
            'kegiatan' => $kegiatan,
            'status' => $status,
            'pager' => $this->data_presensi->pager,
            'current_page' => $current_page
        ];
        return view('dashboard/presensi', $data);
    }

    public function download_presensi($id)
    {
        $spreadsheet = new Spreadsheet();

        $presensi = $this->data_presensi->getPresensi($id);
        $kegiatan = $this->data_kegiatan->getKegiatan($id);
        $filename = 'Presensi_' . $kegiatan['nama_kegiatan'] . '_' . $kegiatan['tanggal_kegiatan'] . '.xlsx';
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Timestamp');
        $sheet->setCellValue('C1', 'Nama Lengkap');
        $sheet->setCellValue('D1', 'Nomor Anggota');
        $row = 2;

        foreach ($presensi as $c) {
            $sheet->setCellValue('A' . $row, $row - 1);
            $sheet->setCellValue('B' . $row, $c['waktu']);
            $sheet->setCellValue('C' . $row, $c['nama_lengkap']);
            $sheet->setCellValue('D' . $row, $c['nomor_anggota']);
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

        $kegiatan = $this->data_kegiatan->getKegiatan($id);

        $tgl_kegiatan = new DateTime($kegiatan['tanggal_kegiatan']);
        $today = new DateTime();

        if ($tgl_kegiatan < $today) {
            $status = 'Selesai';
        } else {
            $status = 'Belum Selesai';
        }

        $data = [
            'title' => 'QR Code',
            'kegiatan' => $kegiatan,
            'status'    => $status,
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
    // End of Kegiatan Function

    public function login()
    {
        $data = [
            'title' => 'Login'
        ];

        return view('/auth/login', $data);
    }

    public function logout()
    {
        if ($this->auth->check()) {
            $this->auth->logout();
        }

        return redirect()->to(site_url('/'));
    }

    public function program_kerja()
    {
        $search = $this->request->getVar('search');
        if (user()->username == 'admin' || user()->username == 'ketua_umum' || user()->username == 'badan_pengawas') {
            if ($search) {
                $program_kerja = $this->progja->select('program_kerja.id, program_kerja.nama_program, program_kerja.lpj, program_kerja.deskripsi, program_kerja.rencana_pelaksanaan, users.username, program_kerja.status')
                    ->join('users', 'program_kerja.user=users.id')->like('nama_program', $search)
                    ->orLike('users.username', $search)->findAll();
            } else {
                $program_kerja = $this->progja->select('program_kerja.id, program_kerja.nama_program, program_kerja.lpj, program_kerja.deskripsi, program_kerja.rencana_pelaksanaan, users.username, program_kerja.status')
                    ->join('users', 'program_kerja.user=users.id')->findAll();
            }
        } else {
            if ($search) {
                $program_kerja = $this->progja->select('program_kerja.id, program_kerja.nama_program, program_kerja.lpj, program_kerja.deskripsi, program_kerja.rencana_pelaksanaan, users.username, program_kerja.status')
                    ->join('users', 'program_kerja.user=users.id')->where('program_kerja.user', user()->id)->like('nama_program', $search)
                    ->orLike('users.username', $search)->findAll();
            } else {
                $program_kerja = $this->progja->select('program_kerja.id, program_kerja.nama_program, program_kerja.lpj, program_kerja.deskripsi, program_kerja.rencana_pelaksanaan, users.username, program_kerja.status')
                    ->join('users', 'program_kerja.user=users.id')->where('program_kerja.user', user()->id)->findAll();
            }
        }
        // dd($program_kerja);
        $data = [
            'title' => 'Program Kerja',
            'progja' => $program_kerja,
        ];

        return view('/dashboard/program_kerja', $data);
    }

    public function add_progja()
    {
        // dd(Time::now()->getYear());
        $data = [
            'title' => 'Tambah Program Kerja',
            'validation' => \Config\Services::validation(),
        ];

        return view('/dashboard/add_progja', $data);
    }

    public function save_progja()
    {
        $input = $this->request->getVar();

        $validation = [
            'nama_program' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Program Kerja harus diisi'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi Program Kerja harus diisi'
                ]
            ],
            'rencana_pelaksanaan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Rencana Pelaksanaan Program Kerja harus diisi'
                ]
            ],
        ];

        $edit = isset($input['id']);

        // dd($edit);

        if (!$this->validate($validation)) {
            return redirect()->to(site_url('dashboard/' . ($edit ? 'edit_progja' : 'add_progja')))->withInput();
        }


        if ($edit) {
            $save = [
                'id'                    => $input['id'],
                'nama_program'          => $input['nama_program'],
                'deskripsi'             => $input['deskripsi'],
                'rencana_pelaksanaan'   => $input['rencana_pelaksanaan'],
                'user'                  => user()->id,
                'tahun'                 => Time::now('Asia/Jakarta', 'id_ID')->getYear(),
            ];
            if (in_groups('admin')) {
                $save['status'] = $input['status'];
            }
        } else {
            $save = [
                'nama_program'          => $input['nama_program'],
                'deskripsi'             => $input['deskripsi'],
                'rencana_pelaksanaan'   => $input['rencana_pelaksanaan'],
                'user'                  => user()->id,
                'tahun'                 => Time::now('Asia/Jakarta', 'id_ID')->getYear(),
                'status'                => 'Belum Terlaksana',
            ];
        }

        if (!$this->progja->save($save)) {
            session()->setFlashdata('error', 'Gagal Menambahkan Program Kerja');
            return redirect()->to(site_url('dashboard/' . ($edit ? 'edit_progja' : 'add_progja')));
        }

        session()->setFlashdata('success', 'Berhasil Menambahkan Program Kerja');
        return redirect()->to(site_url('dashboard/program_kerja'));
    }

    public function edit_progja()
    {
        $id = $this->request->getVar('id');
        $progja = $this->progja->where('id', $id)->first();
        $data = [
            'title' => 'Edit Program Kerja',
            'progja' => $progja,
            'validation' => \Config\Services::validation(),
        ];

        return view('/dashboard/edit_progja', $data);
    }

    public function delete_progja()
    {
        $id = $this->request->getVar('id');
        $progja = $this->progja->where('id', $id)->first();
        unlink('assets/uploads/document/lpj/' . $progja->lpj);
        if (!$this->progja->where('id', $id)->delete()) {
            session()->setFlashdata('error', 'Gagal Menghapus Program Kerja');
            return redirect()->to(site_url('dashboard/program_kerja'));
        }

        session()->setFlashdata('success', 'Berhasil Menghapus Program Kerja');
        return redirect()->to(site_url('dashboard/program_kerja'));
    }

    public function upload_lpj()
    {
        $id = $this->request->getVar('id');
        $progja = $this->progja->where('id', $id)->first();
        $data = [
            'title' => 'Upload LPJ',
            'validation' => \Config\Services::validation(),
            'progja' => $progja,
        ];

        return view('/dashboard/upload_lpj', $data);
    }

    public function save_lpj()
    {
        $input = $this->request->getVar();
        $validation = [
            'lpj' => [
                'rules' => 'uploaded[lpj]|ext_in[lpj,pdf]|mime_in[lpj,application/pdf]',
                'errors' => [
                    'uploaded' => 'File LPJ harus diisi',
                    'ext_in' => 'File LPJ harus berformat PDF',
                    'mime_in' => 'File LPJ harus berformat PDF',
                ]
            ],
        ];

        if (!$this->validate($validation)) {
            return redirect()->to(site_url('dashboard/upload_lpj'))->withInput();
        }

        $file = $this->request->getFile('lpj');
        $name = $input['nama_program'] . '_' . Time::now('Asia/Jakarta', 'id_ID')->getYear() . '.pdf';
        $file->move('assets/uploads/document/lpj', $name);
        // dd($file);
        $save = [
            'id' => $input['id'],
            'lpj' => $name,
            'status' => 'Sudah Terlaksana',
        ];
        // dd($save);

        if (!$this->progja->save($save)) {
            unlink('assets/uploads/document/lpj/' . $save['lpj']);
            session()->setFlashdata('error', 'Gagal Mengupload LPJ');
            return redirect()->to(site_url('dashboard/upload_lpj'));
        }

        session()->setFlashdata('success', 'Berhasil Mengupload LPJ');
        return redirect()->to(site_url('dashboard/program_kerja'));
    }

    public function view_lpj($id)
    {
        $data = [
            'title' => 'View LPJ',
            'file'  => $id,
        ];

        return view('/dashboard/view_lpj', $data);
    }
}
