<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaModel;
use App\Models\SimpananModel;
use App\Models\PembayaranSimwa;

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
        $simpanan = $this->data_simpanan->join('data_anggota', 'data_simpanan.npm=data_anggota.npm')->paginate(25, 'data_simpanan');
        $current_page = $this->request->getVar('page_data_simpanan') ? $this->request->getVar('page_data_simpanan') : 1;
        $data = [
            'title' => 'Data Simpanan',
            'simpanan' => $simpanan,
            'pager' => $this->data_simpanan->pager,
            'current_page' => $current_page
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
            'current_page' => $current_page
        ];
        return view('keuangan/pembayaran_simwa', $data);
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
        return view('keuangan/add_simpanan', $data);
    }

    public function save_simpanan()
    {
        $nomor_anggota = $this->data_anggota->select('nomor_anggota')->where('npm', $this->request->getVar('npm'))
            ->first();
        $id_pembayaran = uniqid();

        $this->bayar_simwa->insert([
            'id_pembayaran' => $id_pembayaran,
            'nomor_anggota' => $nomor_anggota['nomor_anggota'],
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
        $npm = $this->data_anggota->select('npm')->where('nomor_anggota', $temp['nomor_anggota'])->first();
        $simpanan_lama = $this->data_simpanan->where('npm', $npm['npm'])->first();
        $simwa = $simpanan_lama['simpanan_wajib'] + $temp['nominal'];
        $this->bayar_simwa->update($id, [
            'status' => 3
        ]);
        $this->data_simpanan->update($npm['npm'], [
            'simpanan_wajib' => $simwa,
            'total_simpanan' => $simpanan_lama['simpanan_pokok'] + $simwa,
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
}
