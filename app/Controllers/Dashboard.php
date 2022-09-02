<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\CalonModel;
use App\Models\KegiatanModel;
use App\Models\PoinModel;
use App\Models\SimpananModel;

class Dashboard extends BaseController
{
    protected $data_anggota;
    protected $data_kegiatan;
    protected $data_simpanan;
    protected $calon_anggota;
    protected $data_poin;

    function __construct()
    {
        $this->data_anggota = new AnggotaModel();
        $this->data_kegiatan = new KegiatanModel();
        $this->data_simpanan = new SimpananModel();
        $this->calon_anggota = new CalonModel();
        $this->data_poin = new PoinModel();
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
        $poin = $this->data_poin->getPoin();
        $data = [
            'title' => 'Data Poin',
            'data' => $poin
        ];
        return view('dashboard/data_poin', $data);
    }

    public function data_simpanan()
    {
        $simpanan = $this->data_simpanan->getSimpanan();
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

    public function calon_anggota()
    {
        $calon = $this->calon_anggota->getCalonAnggota();
        $data = [
            'title' => 'Calon Anggota',
            'calon_anggota' => $calon
        ];
        return view('dashboard/calon_anggota', $data);
    }
}
