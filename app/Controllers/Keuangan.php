<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaModel;
use App\Models\LaporanKeuangan;
use App\Models\SimpananModel;
use App\Models\PembayaranSimwa;
use CodeIgniter\I18n\Time;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Keuangan extends BaseController
{
    protected $data_anggota;
    protected $data_simpanan;
    protected $bayar_simwa;
    protected $laporan_keuangan;

    public function __construct()
    {
        $this->data_anggota = new AnggotaModel();
        $this->data_simpanan = new SimpananModel();
        $this->bayar_simwa = new PembayaranSimwa();
        $this->laporan_keuangan = new LaporanKeuangan();
    }

    public function index()
    {
        return redirect()->to('/keuangan/data_simpanan');
    }

    public function data_simpanan()
    {
        // dd(abs(Time::today()->difference('2022-10-01')->getMonths()));
        $search = $this->request->getVar('search');
        if ($search) {
            $simpanan = $this->data_simpanan->join('data_anggota', 'data_simpanan.nomor_anggota=data_anggota.nomor_anggota')
                ->like('data_anggota.nama_lengkap', $search)->orLike('data_anggota.nomor_anggota', $search)
                ->orderBy('data_anggota.nomor_anggota', 'ASC')->paginate(25, 'data_simpanan');
        } else {
            $simpanan = $this->data_simpanan->join('data_anggota', 'data_simpanan.nomor_anggota=data_anggota.nomor_anggota')
                ->orderBy('data_anggota.nomor_anggota', 'ASC')->paginate(25, 'data_simpanan');
        }
        $current_page = $this->request->getVar('page_data_simpanan') ? $this->request->getVar('page_data_simpanan') : 1;
        $data = [
            'title' => 'Data Simpanan',
            'simpanan' => $simpanan,
            'pager' => $this->data_simpanan->pager,
            'current_page' => $current_page,
            'date'  => Time::today(),
            'validation' => \Config\Services::validation(),
        ];
        return view('keuangan/data_simpanan', $data);
    }

    public function pembayaran_simwa()
    {
        $simwa = $this->bayar_simwa->join('data_anggota', 'data_anggota.nomor_anggota=pembayaran_simwa.nomor_anggota')->orderBy('id_pembayaran', 'DESC')->paginate(25, 'pembayaran_simwa');
        $current_page = $this->request->getVar('page_pembayaran_simwa') ? $this->request->getVar('page_pembayaran_simwa') : 1;
        $data = [
            'title' => 'Pembayaran Simpanan Wajib',
            'simwa' => $simwa,
            'pager' => $this->bayar_simwa->pager,
            'current_page' => $current_page,
            'validation' => \Config\Services::validation(),
        ];
        return view('keuangan/pembayaran_simwa', $data);
    }


    public function add_simpanan()
    {
        $nomor_anggota = $this->request->getVar('nomor_anggota');
        $nama = $this->data_anggota->select('nama_lengkap')->where('nomor_anggota', $nomor_anggota)
            ->first();
        $data = [
            'title' => 'Tambah Simpanan',
            'nomor_anggota' => $nomor_anggota,
            'nama' => $nama
        ];
        return view('keuangan/add_simpanan', $data);
    }

    public function save_simpanan()
    {
        // dd($this->request->getVar());
        $nomor_anggota = $this->request->getVar('nomor_anggota');
        $id_pembayaran = uniqid();

        $this->bayar_simwa->insert([
            'id_pembayaran' => $id_pembayaran,
            'timestamp' => Time::now('Asia/Jakarta'),
            'nomor_anggota' => $nomor_anggota,
            'nominal' => $this->request->getVar('nominal'),
            'status' => 1,
            'bukti_pembayaran' => '-',
        ]);

        // $this->bayar_simwa->c
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        return redirect()->to('/keuangan/data_simpanan/' . $this->request->getVar('npm'));
    }

    public function accept($id)
    {
        $temp = $this->bayar_simwa->select('nomor_anggota, nominal')->where('id_pembayaran', $id)->first();
        // $npm = $this->data_anggota->select('npm')->where('nomor_anggota', $temp['nomor_anggota'])->first();
        $simpanan_lama = $this->data_simpanan->where('nomor_anggota', $temp['nomor_anggota'])->first();
        $simwa = $simpanan_lama['simpanan_wajib'] + $temp['nominal'];
        $tagihan = $simpanan_lama['tagihan'] - $temp['nominal'];
        if ($tagihan <= 0) {
            $tagihan = 0;
        }
        $this->bayar_simwa->update($id, [
            'status' => 3
        ]);
        $this->data_simpanan->update($temp['nomor_anggota'], [
            'simpanan_wajib' => $simwa,
            'tagihan' => $tagihan,
        ]);
        return redirect()->to('/keuangan/pembayaran_simwa');
    }

    public function reject($id)
    {
        $this->bayar_simwa->update($id, [
            'status' => 2
        ]);
        return redirect()->to('/keuangan/pembayaran_simwa');
    }

    public function upload_data()
    {
        $file = $this->request->getFile('file');
        if ($file->getExtension() == 'xlsx') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        } else if ($file->getExtension() == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            session()->setFlashdata('error', 'File yang anda masukkan bukan file excel');
            return redirect()->to('/keuangan/data_anggota');
        }

        $spreadsheet = $reader->load($file);
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->removeRow(1);
        $spreadsheet = $spreadsheet->getActiveSheet()->toArray();
        // dd($spreadsheet);

        foreach ($spreadsheet as $s) {
            $save = [
                'nomor_anggota' => $s[1],
                'simpanan_pokok' => $s[2],
                'simpanan_wajib'    => $s[3],
                'tagihan' => $s[4],
            ];

            if (!$this->data_simpanan->save($save)) {
                session()->setFlashdata('error', 'Terjadi kesalahan pada data ' . $s[0]);
                return redirect()->to('/keuangan/data_simpanan');
            }
        }
        session()->setFlashdata('pesan', 'Data berhasil diupload');
        return redirect()->to('/keuangan/data_simpanan');
    }

    public function save_excel()
    {
        $filename = 'simpanan.xlsx';

        $spreadsheet = new Spreadsheet();
        $writer = new Xlsx($spreadsheet);

        $simpanan = $this->data_simpanan->join('data_anggota', 'data_anggota.nomor_anggota=data_simpanan.nomor_anggota')->findAll();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Lengkap');
        $sheet->setCellValue('C1', 'Nomor Anggota');
        $sheet->setCellValue('D1', 'Keanggotaan');
        $sheet->setCellValue('E1', 'Simpanan Pokok');
        $sheet->setCellValue('F1', 'Simpanan Wajib');
        $sheet->setCellValue('G1', 'Total Simpanan');
        $sheet->setCellValue('H1', 'Tagihan');
        $row = 2;
        $i = 1;
        $date = Time::today('Asia/Jakarta');

        foreach ($simpanan as $c) {
            $tagihan = 0;
            if ($c['tgl_diksar'] < '2022-01-01') {
                $tagihan = date_diff(date_create($c['tgl_diksar']), date_create('2022-01-01'))->m * 5000;
                $month = abs($date->difference('2022-01-01')->getMonths());
            } else {
                $month = abs($date->difference($c['tgl_diksar'])->getMonths());
            }

            $sheet->setCellValue('A' . $row, $i++);
            $sheet->setCellValue('B' . $row, $c['nama_lengkap']);
            $sheet->setCellValue('C' . $row, $c['nomor_anggota']);
            $sheet->setCellValue('D' . $row, $c['keanggotaan']);
            $sheet->setCellValue('E' . $row, $c['simpanan_pokok']);
            $sheet->setCellValue('F' . $row, $c['simpanan_wajib']);
            $sheet->setCellValue('G' . $row, $c['simpanan_pokok'] + $c['simpanan_wajib']);
            $sheet->setCellValue('H' . $row, $c['tagihan'] == null ? '0' : $c['tagihan']);
            $row++;
        }

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

    // Laporan Keuangan
    public function laporan_keuangan()
    {
        $search = $this->request->getVar('search');
        if ($search) {
            $this->laporan_keuangan->like('bulan', $search)->orLike('tahun', $search)
                ->orderBy('tahun', 'DESC')->orderBy('bulan', 'DESC')->findAll();
        } else {
            $this->laporan_keuangan->orderBy('tahun', 'DESC')->orderBy('bulan', 'DESC')->findAll();
        }

        $data = [
            'title' => 'Laporan Keuangan',
            'laporan' => $this->laporan_keuangan->paginate(10, 'laporan_keuangan'),
            'search' => $search,
        ];

        return view('keuangan/laporan_keuangan', $data);
    }

    public function add_laporan()
    {
        $month = [
            [
                'id' => '01',
                'name' => 'Januari'
            ],
            [
                'id' => '02',
                'name' => 'Februari'
            ],
            [
                'id' => '03',
                'name' => 'Maret'
            ],
            [
                'id' => '04',
                'name' => 'April'
            ],
            [
                'id' => '05',
                'name' => 'Mei'
            ],
            [
                'id' => '06',
                'name' => 'Juni'
            ],
            [
                'id' => '07',
                'name' => 'Juli'
            ],
            [
                'id' => '08',
                'name' => 'Agustus'
            ],
            [
                'id' => '09',
                'name' => 'September'
            ],
            [
                'id' => '10',
                'name' => 'Oktober'
            ],
            [
                'id' => '11',
                'name' => 'November'
            ],
            [
                'id' => '12',
                'name' => 'Desember'
            ],
        ];
        $year = array();
        for ($i = 2022; $i <= Time::today()->getYear(); $i++) {
            $year[] = $i;
        }
        $data = [
            'title' => 'Tambah Laporan Keuangan',
            'validation' => \Config\Services::validation(),
            'month' => $month,
            'year' => $year,
        ];

        return view('keuangan/add_laporan', $data);
    }

    public function save_laporan()
    {
        $validation = [
            'judul' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Judul harus diisi'
                ]
            ],
            'bulan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Bulan harus diisi'
                ]
            ],
            'tahun' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun harus diisi'
                ]
            ],
            'file'  => [
                'rules' => 'uploaded[file]|ext_in[file,pdf]|mime_in[file,application/pdf]|',
                'errors' => [
                    'uploaded' => 'File harus diisi',
                    'mime_in' => 'File harus berformat PDF',
                    'ext_in' => 'File harus berformat PDF'
                ]
            ],
        ];

        if (!$this->validate($validation)) {
            return redirect()->to('/keuangan/add_laporan')->withInput();
        }

        $file = $this->request->getFile('file');
        $file->move('assets/uploads/document/laporan_keuangan');

        $save = [
            'judul' => $this->request->getVar('judul'),
            'bulan' => $this->request->getVar('bulan'),
            'tahun' => $this->request->getVar('tahun'),
            'file' => $file->getName(),
        ];

        if (!$this->laporan_keuangan->save($save)) {
            session()->setFlashdata('error', 'Gagal menambahkan laporan keuangan');
            return redirect()->to('/keuangan/add_laporan')->withInput();
        }

        session()->setFlashdata('success', 'Berhasil menambahkan laporan keuangan');
        return redirect()->to('/keuangan/laporan_keuangan');
    }

    public function delete_laporan()
    {
        $id = $this->request->getVar('id');
        // dd($id);
        $laporan = $this->laporan_keuangan->where('id', $id)->first();
        // dd($laporan);
        unlink('assets/uploads/document/laporan_keuangan/' . $laporan->file);
        if (!$this->laporan_keuangan->delete($id)) {
            session()->setFlashdata('error', 'Gagal menghapus laporan keuangan');
            return redirect()->to('/keuangan/laporan_keuangan');
        }
        session()->setFlashdata('success', 'Berhasil menghapus laporan keuangan');
        return redirect()->to('/keuangan/laporan_keuangan');
    }

    public function view_laporan($file)
    {
        $data = [
            'title' => 'View Laporan Keuangan',
            'file' => $file,
        ];
        return view('keuangan/view_laporan', $data);
    }
}
