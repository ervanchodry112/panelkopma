<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HasilSurveyModel;
use App\Models\SurveyBerjalanModel;
use CodeIgniter\I18n\Time;
use Config\Validation;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Date;

class Litbang extends BaseController
{
    protected $hasil_survey;
    protected $survey;

    public function __construct()
    {
        $this->hasil_survey = new HasilSurveyModel();
        $this->survey = new SurveyBerjalanModel();
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
            'title' => 'Tambah Laporan',
            'validation' => \Config\Services::validation()
        ];
        return view('litbang/add_report', $data);
    }

    public function delete_report($id_laporan)
    {
        $laporan = $this->hasil_survey->find($id_laporan);

        unlink('assets/uploads/document/hasil_survey/' . $laporan['file']);

        $this->hasil_survey->delete($id_laporan);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/litbang/hasil_survey');
    }

    public function edit_report($id_laporan)
    {
        $data = [
            'title' => 'Edit Laporan',
            'validation' => \Config\Services::validation(),
            'laporan' => $this->hasil_survey->find($id_laporan)
        ];
        return view('litbang/edit_report', $data);
    }

    public function save_report()
    {
        if (!$this->validate([
            'nama_survey' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'tanggal_mulai' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tentukan tanggal survey dimulai!'
                ]
            ],
            'tanggal_selesai' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tentukan tanggal survey selesai!'
                ]
            ],
            'file' => [
                'rules' => 'uploaded[file]|ext_in[file,pdf]|mime_in[file,application/pdf]',
                'errors' => [
                    'required' => 'Pilih gambar terlebih dahulu!',
                    'ext_in' => 'File harus berupa PDF'
                ]
            ]

        ])) {
            return redirect()->to('/litbang/add_report')->withInput();
        }

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

    public function update_report()
    {
        if (!$this->validate([
            'nama_survey' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'tanggal_mulai' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tentukan tanggal survey dimulai!'
                ]
            ],
            'tanggal_selesai' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tentukan tanggal survey selesai!'
                ]
            ],
            'file' => [
                'rules' => 'ext_in[file,pdf]|mime_in[file,application/pdf]',
                'errors' => [
                    'ext_in' => 'File harus berupa PDF',
                    'mime_in' => 'File harus berupa PDF'
                ]
            ]

        ])) {
            return redirect()->to('/litbang/edit_report' . $this->request->getVar('id_laporan'))->withInput();
        }

        $file = $this->request->getFile('file');

        if ($file->getError() == 4) {
            $fileName = $this->request->getVar('file_lama');
        } else {
            $fileName = $file->getRandomName();
            $file->move('assets/uploads/document/hasil_survey', $fileName);
            unlink('assets/uploads/document/hasil_survey/' . $this->request->getVar('file_lama'));
        }

        $this->hasil_survey->save([
            'nama_survey' => $this->request->getVar('nama_survey'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'tanggal_mulai' => $this->request->getVar('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getVar('tanggal_selesai'),
            'file' => $fileName
        ]);
    }

    public function view_report($name)
    {
        $file = "assets/uploads/document/hasil_survey/" . $name;

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

    public function survey_berjalan()
    {
        $search = $this->request->getVar('search');
        if ($search) {
            $data_survey = $this->survey->like('nama_survey', $search)->findAll();
        } else {
            $data_survey = $this->survey->findAll();
        }

        $data = [
            'title' => 'Survey Berjalan',
            'validation' => \Config\Services::validation(),
            'survey' => $data_survey,
        ];
        return view('litbang/survey_berjalan', $data);
    }

    public function tambah_survey()
    {
        $data = [
            'title' => 'Tambah Survey',
            'validation' => \Config\Services::validation(),
        ];
        return view('litbang/tambah_survey', $data);
    }

    public function save_survey()
    {
        $input = $this->request->getVar();

        $validation = [
            'nama_survey' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'tgl_mulai' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tentukan tanggal survey dimulai!'
                ]
            ],
            'tgl_selesai' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tentukan tanggal survey selesai!'
                ]
            ],
            'link' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Link survey harus diisi!',
                ]
            ]
        ];

        if (!$this->validate($validation)) {
            return redirect()->to('/litbang/tambah_survey')->withInput();
        }

        $data = [
            'nama_survey' => $input['nama_survey'],
            'deskripsi' => $input['deskripsi'],
            'tgl_mulai' => $input['tgl_mulai'],
            'tgl_selesai' => $input['tgl_selesai'],
            'link' => $input['link']
        ];

        if (!$this->survey->save($data)) {
            session()->setFlashdata('error', 'Gagal menambahkan data survey');
            return redirect()->to('/litbang/tambah_survey')->withInput();
        }

        session()->setFlashdata('success', 'Berhasil menambahkan data survey');
        return redirect()->to('/litbang/survey_berjalan');
    }

    public function edit_survey()
    {
        $id = $this->request->getVar('id');

        $data_survey = $this->survey->where('id', $id)->first();
        $data = [
            'title' => 'Edit Survey',
            'validation' => \Config\Services::validation(),
            'survey' => $data_survey,
        ];

        return view('litbang/edit_survey', $data);
    }

    public function attempt_edit_survey()
    {
        $input = $this->request->getVar();
        $save = [
            'id' => $input['id'],
            'nama_survey' => $input['nama_survey'],
            'deskripsi' => $input['deskripsi'],
            'tgl_mulai' => $input['tgl_mulai'],
            'tgl_selesai' => $input['tgl_selesai'],
            'link' => $input['link']
        ];

        if (!$this->survey->save($save)) {
            session()->setFlashdata('error', 'Gagal mengubah data survey');
            return redirect()->to('/litbang/edit_survey?id=' . $input['id'])->withInput();
        }

        session()->setFlashdata('success', 'Berhasil mengubah data survey');
        return redirect()->to('/litbang/survey_berjalan');
    }

    public function delete_survey()
    {
        $id = $this->request->getVar('id');
        if (!$this->survey->where('id', $id)->delete()) {
            session()->setFlashdata('error', 'Gagal menghapus data survey');
            return redirect()->to('/litbang/survey_berjalan');
        }

        session()->setFlashdata('success', 'Berhasil menghapus data survey');
        return redirect()->to('/litbang/survey_berjalan');
    }

    public function finish_survey()
    {
        $id = $this->request->getVar('id');

        $save = [
            'id' => $id,
            'tgl_selesai' => Time::today('Asia/Jakarta')->toDateString(),
        ];

        if (!$this->survey->save($save)) {
            session()->setFlashdata('error', 'Gagal menyelesaikan survey');
            return redirect()->to('/litbang/survey_berjalan');
        }

        session()->setFlashdata('success', 'Berhasil menyelesaikan survey');
        return redirect()->to('/litbang/survey_berjalan');
    }
}
