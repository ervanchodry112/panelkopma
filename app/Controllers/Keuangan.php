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
        $simpanan = $this->data_simpanan->getSimpanan();
        $data = [
            'title' => 'Data Simpanan',
            'simpanan' => $simpanan
        ];
        return view('keuangan/data_simpanan', $data);
    }

    public function pembayaran_simwa()
    {
        $simwa = $this->bayar_simwa->getPembayaran();
        $data = [
            'title' => 'Pembayaran Simpanan Wajib',
            'simwa' => $simwa
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
        // d($nomor_anggota);
        // d($id_pembayaran);
        // dd($this->request->getVar());
        $this->bayar_simwa->save([
            'id_pembayaran' => $id_pembayaran,
            'nomor_anggota' => $nomor_anggota['nomor_anggota'],
            'nominal' => $this->request->getVar('nominal'),
            'status' => 3,
            'bukti_pembayaran' => '-'
        ]);

        // $this->bayar_simwa->c
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

        return redirect()->to('/keuangan/add_simpanan/' . $this->request->getVar('npm'));
    }
}
