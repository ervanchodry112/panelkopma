<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AlumniModel;

class Humas extends BaseController
{
    protected $alumniModel;

    public function __construct()
    {
        $this->alumniModel = new AlumniModel();
    }

    public function alumni()
    {
        $search = $this->request->getVar('search');

        if ($search) {
            $alumni = $this->alumniModel->like('nama_alumni', $search)->orLike('email_alumni', $search)->orLike('no_hp_alumni', $search)->orLike('alamat_alumni', $search)->orLike('status_alumni', $search)->orLike('tahun_lulus', $search)->paginate(50, 'alumni');
        } else {
            $alumni = $this->alumniModel->paginate(50, 'alumni');
        }

        $data = [
            'title' => 'Alumni',
            'alumni' => $alumni,
            'pager' => $this->alumniModel->pager,
            'currentPage' => $this->request->getVar('page_alumni') ? $this->request->getVar('page_alumni') : 1,
        ];
        return view('humas/alumni', $data);
    }

    public function add_alumni()
    {
        $data = [
            'title' => 'Tambah Alumni',
            'validation' => \Config\Services::validation(),
        ];
        return view('humas/add_alumni', $data);
    }

    public function save_alumni()
    {
        $input = $this->request->getVar();
        $validation = [
            'nama_alumni' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama alumni harus diisi',
                ]
            ],
            'email_alumni' => [
                'rules' => 'required|valid_email|is_unique[alumni.email_alumni]',
                'errors' => [
                    'required' => 'Email alumni harus diisi',
                    'valid_email' => 'Email alumni tidak valid',
                    'is_unique' => 'Email alumni sudah terdaftar',
                ]
            ],
            'no_hp_alumni' => [
                'rules' => 'required|is_unique[alumni.no_hp_alumni]',
                'errors' => [
                    'required' => 'No. HP alumni harus diisi',
                    'is_unique' => 'No. HP alumni sudah terdaftar',
                ]
            ],
            'status_alumni' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status alumni harus diisi',
                ]
            ],
            'tahun_lulus' => [
                'rules' => 'numeric|min_length[4]|max_length[4]',
                'errors' => [
                    'numeric' => 'Tahun lulus harus berupa angka',
                    'min_length' => 'Tahun lulus harus 4 digit',
                    'max_length' => 'Tahun lulus harus 4 digit',
                ]
            ],
        ];

        if (!$this->validate($validation)) {

            return redirect()->to('/humas/add_alumni')->withInput();
        }

        $slug = $this->alumniModel->create_slug($input['nama_alumni']);
        if (!$slug) {
            dd($slug);
            session()->setFlashdata('error', 'Nama alumni sudah terdaftar');
            return redirect()->to('/humas/add_alumni')->withInput();
        }

        $input['slug_alumni'] = $slug;
        if (!$this->alumniModel->save($input)) {
            session()->setFlashdata('error', 'Gagal menambahkan alumni');
            return redirect()->to('/humas/add_alumni')->withInput();
        }

        session()->setFlashdata('success', 'Alumni berhasil ditambahkan');
        return redirect()->to('/humas/alumni');
    }

    public function edit_alumni($slug)
    {

        $alumni = $this->alumniModel->getAlumni($slug);

        if (!$alumni) {
            session()->setFlashdata('error', 'Alumni tidak ditemukan');
            return redirect()->to('/humas/alumni');
        }

        $data = [
            'title' => 'Edit Alumni',
            'validation' => \Config\Services::validation(),
            'alumni' => $alumni,
        ];
        return view('humas/edit_alumni', $data);
    }

    public function save_edited_alumni()
    {
        $input = $this->request->getVar();
        $validation = [
            'nama_alumni' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama alumni harus diisi',
                ]
            ],
            'email_alumni' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email alumni harus diisi',
                    'valid_email' => 'Email alumni tidak valid',

                ]
            ],
            'no_hp_alumni' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No. HP alumni harus diisi',

                ]
            ],
            'status_alumni' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status alumni harus diisi',
                ]
            ],
            'tahun_lulus' => [
                'rules' => 'numeric|min_length[4]|max_length[4]',
                'errors' => [
                    'numeric' => 'Tahun lulus harus berupa angka',
                    'min_length' => 'Tahun lulus harus 4 digit',
                    'max_length' => 'Tahun lulus harus 4 digit',
                ]
            ],
        ];

        if (!$this->validate($validation)) {
            return redirect()->to('/humas/edit_alumni')->withInput();
        }

        if (!$this->alumniModel->save($input)) {
            session()->setFlashdata('error', 'Gagal menyimpan data');
            return redirect()->to('/humas/add_alumni')->withInput();
        }

        session()->setFlashdata('success', 'Data berhasil disimpan');
        return redirect()->to('/humas/alumni');
    }

    public function delete_alumni()
    {
        $slug = $this->request->getVar('slug');

        $cek = $this->alumniModel->getAlumni($slug);

        if (!$cek) {
            session()->setFlashdata('error', 'Data alumni tidak ditemukan');
            return redirect()->to('/humas/alumni');
        }

        if (!$this->alumniModel->delete($cek->id_alumni)) {
            session()->setFlashdata('error', 'Gagal menghapus alumni');
            return redirect()->to('/humas/alumni');
        }

        session()->setFlashdata('success', 'Alumni berhasil dihapus');
        return redirect()->to('/humas/alumni');
    }

    public function upload_alumni()
    {
        $file = $this->request->getFile('csv');
        if ($file->getExtension() == 'xlsx') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        } else if ($file->getExtension() == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        }

        $spreadsheet = $reader->load($file);
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->removeRow(1);
        $spreadsheet = $spreadsheet->getActiveSheet()->toArray();

        foreach ($spreadsheet as $s) {
            $save = [
                'nama_alumni'   => $s[0],
                'email_alumni'  => $s[1],
                'no_hp_alumni'  => $s[2],
                'alamat_alumni' => $s[3],
                'status_alumni' => $s[4],
                'tahun_lulus'   => $s[5],
                
            ];

            $slug = $this->alumniModel->create_slug($s[0]);

            if(!$slug) {
                session()->setFlashdata('error', 'Data gagal ditambahkan');
                return redirect()->to('/humas/alumni');
            }

            $save['slug_alumni'] = $slug;

            if (!$this->alumniModel->insert($save, false)) {
                session()->setFlashdata('error', 'Data gagal ditambahkan');
                return redirect()->to('/humas/alumni');
            }
        }

        session()->setFlashdata('success', 'Data berhasil diupload');
        return redirect()->to('/humas/alumni');
    }
}
