<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaModel;
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

    public function __construct()
    {
        $this->data_anggota = new AnggotaModel();
        $this->data_simpanan = new SimpananModel();
        $this->bayar_simwa = new PembayaranSimwa();
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
        $simwa = $this->bayar_simwa->join('data_anggota', 'data_anggota.nomor_anggota=pembayaran_simwa.nomor_anggota')->paginate(25, 'pembayaran_simwa');
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
            'bukti_pembayaran' => '-'
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
        $this->bayar_simwa->update($id, [
            'status' => 3
        ]);
        $this->data_simpanan->update($temp['nomor_anggota'], [
            'simpanan_wajib' => $simwa,
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
            $tagihan = ($tagihan + ($month * 10000)) - $c['simpanan_wajib'];

            $sheet->setCellValue('A' . $row, $i++);
            $sheet->setCellValue('B' . $row, $c['nama_lengkap']);
            $sheet->setCellValue('C' . $row, $c['nomor_anggota']);
            $sheet->setCellValue('D' . $row, $c['keanggotaan']);
            $sheet->setCellValue('E' . $row, $c['simpanan_pokok']);
            $sheet->setCellValue('F' . $row, $c['simpanan_wajib']);
            $sheet->setCellValue('G' . $row, $c['simpanan_pokok'] + $c['simpanan_wajib']);
            $sheet->setCellValue('H' . $row, $tagihan);
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
}
