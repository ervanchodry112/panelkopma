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
use CodeIgniter\I18n\Time;
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

    function __construct()
    {
        $this->data_kegiatan = new KegiatanModel();
        $this->data_presensi = new Presensi();
        $this->ciqrcode = new Ciqrcode();
        $this->data_user = new UserModel();
        $this->auth   = service('authentication');
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
        $this->data_kegiatan->save([
            'id_kegiatan' => $id,
            'nama_kegiatan' => $this->request->getVar('nama_kegiatan'),
            'tanggal_kegiatan' => $this->request->getVar('tanggal'),
            'tempat_kegiatan' => $this->request->getVar('tempat'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

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

        $current_page = $this->request->getVar('page_presensi') ? $this->request->getVar('page_presensi') : 1;
        $data = [
            'title' => 'Presensi',
            'data' => $presensi,
            'kegiatan' => $this->data_kegiatan->getKegiatan($id),
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
}
