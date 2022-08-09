<?php

namespace App\Controllers;

use App\Models\AnggotaModel;

class Dashboard extends BaseController
{
    protected $data_anggota;
    function __construct()
    {
        $this->data_anggota = new AnggotaModel();
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
        $data = [
            'title' => 'Data Anggota'
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
        $data = [
            'title' => 'Data Simpanan'
        ];
        return view('dashboard/data_simpanan', $data);
    }

    public function data_kegiatan()
    {
        $data = [
            'title' => 'Data Kegiatan'
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
