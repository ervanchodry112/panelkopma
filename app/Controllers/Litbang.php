<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HasilSurveyModel;
use Config\Validation;

class Litbang extends BaseController
{
    protected $hasil_survey;

    public function __construct()
    {
        $this->hasil_survey = new HasilSurveyModel();
    }
    public function index()
    {
        return redirect()->to('/litbang/hasil_survey');
    }

    public function hasil_survey()
    {
        $laporan = $this->hasil_survey->findAll();
        $data = [
            'title' => 'Hasil Survey',
            'laporan' => $laporan
        ];
        return view('litbang/hasil_survey', $data);
    }

    public function add_report()
    {
        $data = [
            'title' => 'Tambah Laporan'
        ];
        return view('litbang/add_report', $data);
    }

    public function save_report()
    {
        // if (!$this->validate([
        //     'nama_survey' => [
        //         'rules' => 'required',
        //         'errors' => [
        //             'required' => '{field} harus diisi'
        //         ]
        //     ],
        //     'deskripsi' => [
        //         'rules' => 'required',
        //         'errors' => [
        //             'required' => '{field} harus diisi'
        //         ]
        //     ],
        //     'tanggal_mulai' => [
        //         'rules' => 'required',
        //         'errors' => [
        //             'required' => 'Tentukan tanggal survey dimulai!'
        //         ]
        //     ],
        //     'tanggal_selesai' => [
        //         'rules' => 'required',
        //         'errors' => [
        //             'required' => 'Tentukan tanggal survey selesai!'
        //         ]
        //     ],
        //     'file' => [
        //         'rules' => 'uploaded[file]|ext_in[file,pdf]|mime_in[file,application/pdf]',
        //         'errors' => [
        //             'required' => 'Pilih gambar terlebih dahulu!',
        //             'ext_in' => 'File harus berupa PDF'
        //         ]
        //     ]

        // ])) {
        //     $validation = new Validation();
        //     return redirect()->to('/litbang/add_report')->withInput()->validate('validation', $validation);
        // }

        $uploadedFile = $this->request->getFile('file');
        $fileName = $uploadedFile->getRandomName();

        $uploadedFile->move('assets/uploads/document/hasil_survey', $fileName);

        $id = uniqid();

        $this->hasil_survey->insert([
            'id_laporan' => $id,
            'nama_survey' => $this->request->getVar('nama_survey'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'tanggal_mulai' => $this->request->getVar('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getVar('tanggal_selesai'),
            'file' => $fileName
        ]);

        return redirect()->to('/litbang/hasil_survey');
    }
}
