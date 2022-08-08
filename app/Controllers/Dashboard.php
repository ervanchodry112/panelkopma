<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        echo view('dashboard/data_anggota');
    }
    public function data_anggota()
    {
        echo view('dashboard/data_anggota');
    }
    public function data_poin()
    {
        echo view('dashboard/data_poin');
    }

    public function data_simpanan()
    {
        echo view('dashboard/data_simpanan');
    }

    public function data_kegiatan()
    {
        return view('dashboard/data_kegiatan');
    }
    public function presensi()
    {
        return view('dashboard/presensi');
    }
}
