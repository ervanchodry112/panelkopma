<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\KegiatanModel;
use App\Models\SimpananModel;

class Dashboard extends BaseController
{
    protected $data_anggota;
    protected $data_kegiatan;
    protected $data_simpanan;

    function __construct()
    {
        $this->data_anggota = new AnggotaModel();
        $this->data_kegiatan = new KegiatanModel();
        $this->data_simpanan = new SimpananModel();
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
        $data = [
            'title' => 'Data Poin'
        ];
        return view('dashboard/data_poin', $data);
    }

    public function data_simpanan()
    {
        $simpanan = $this->data_simpanan->findAll();
        $data = [
            'title' => 'Data Simpanan',
            'simpanan' => $simpanan
        ];
        return view('dashboard/data_simpanan', $data);
    }

    public function data_kegiatan()
    {
        $kegiatan = $this->data_kegiatan->findAll();
        $data = [
            'title' => 'Data Kegiatan',
            'kegiatan' => $kegiatan
        ];
        return view('dashboard/data_kegiatan', $data);
    }
    public function presensi()
    {
        $data = [
            'title' => 'Presensi'
        ];
        return view('dashboard/presensi', $data);
    }

}
