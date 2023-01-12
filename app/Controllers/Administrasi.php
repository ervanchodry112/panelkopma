<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DigilibModel;
use App\Models\SuratKeluarModel;
use App\Models\SuratMasukModel;
use CodeIgniter\I18n\Time;

class Administrasi extends BaseController
{
    protected $surat_masuk;
    protected $surat_keluar;
    protected $digilib;
    public function __construct()
    {
        $this->surat_masuk = new SuratMasukModel();
        $this->surat_keluar = new SuratKeluarModel();
        $this->digilib = new DigilibModel();
    }

    public function surat_masuk()
    {
        $search = $this->request->getVar('search');
        if ($search) {
            $surat_masuk = $this->surat_masuk->like('no_surat', $search)->orLike('asal_surat', $search)
                ->orLike('isi_surat', $search)->findAll();
        } else {
            $surat_masuk = $this->surat_masuk->findAll();
        }

        $data = [
            'title' => 'Surat Masuk',
            'surat_masuk' => $surat_masuk,
        ];
        return view('administrasi/surat_masuk', $data);
    }

    public function add_surat_masuk()
    {
        $data = [
            'title' => 'Tambah Surat Masuk',
            'validation' => \Config\Services::validation(),
        ];
        return view('administrasi/add_surat_masuk', $data);
    }

    public function save_surat_masuk()
    {
        $input = $this->request->getVar();
        $validation = [
            'no_surat' => [
                'rules' => 'required|is_unique[surat_masuk.no_surat]',
                'errors' => [
                    'required' => 'No Surat harus diisi',
                    'is_unique' => 'No Surat sudah ada',
                ]
            ],
            'asal_surat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Asal Surat harus diisi',
                ]
            ],
            'isi_surat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Isi Surat harus diisi',
                ]
            ],
            'perihal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Perihal harus diisi',
                ]
            ],
            'kode' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kode harus diisi',
                ]
            ],
            'tgl_surat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Surat harus diisi',
                ]
            ],
            'file' => [
                'rules' => 'uploaded[file]|ext_in[file,pdf]|mime_in[file,application/pdf]',
                'errors' => [
                    'uploaded' => 'File harus diisi',
                    'max_size' => 'File terlalu besar',
                    'ext_in' => 'File harus berformat PDF',
                    'mime_in' => 'File harus berformat PDF',
                ]
            ],
        ];

        if (!$this->validate($validation)) {
            return redirect()->to('/administrasi/add_surat_masuk')->withInput();
        }

        $file = $this->request->getFile('file');
        $file->move('assets/uploads/document/surat_masuk');
        $nama_file = $file->getName();

        $save = [
            'no_surat'      => $input['no_surat'],
            'asal_surat'    => $input['asal_surat'],
            'isi_surat'     => $input['isi_surat'],
            'perihal'       => $input['perihal'],
            'kode'          => $input['kode'],
            'tgl_surat'     => $input['tgl_surat'],
            'tgl_diterima'  => Time::today('Asia/Jakarta')->toDateString(),
            'file'          => $nama_file,
        ];

        if (!$this->surat_masuk->save($save)) {
            session()->setFlashdata('error', 'Data gagal disimpan');
            return redirect()->to('/administrasi/add_surat_masuk')->withInput();
        }

        session()->setFlashdata('success', 'Data berhasil disimpan');
        return redirect()->to('/administrasi/surat_masuk');
    }

    public function view_surat_masuk($file)
    {
        $data = [
            'title' => 'Lihat Surat',
            'file' => $file,
        ];
        return view('administrasi/view_surat_masuk', $data);
    }

    public function edit_surat_masuk($id)
    {
        $surat = $this->surat_masuk->where('id_surat', $id)->first();
        // dd($surat);
        $data = [
            'title' => 'Edit Surat Masuk',
            'validation' => \Config\Services::validation(),
            'surat_masuk' => $surat,
        ];
        return view('administrasi/edit_surat_masuk', $data);
    }

    public function save_edit_surat_masuk()
    {
        $input = $this->request->getVar();
        // dd($input);
        $validation = [
            'no_surat' => [
                'rules' => 'required|',
                'errors' => [
                    'required' => 'No Surat harus diisi',
                ]
            ],
            'asal_surat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Asal Surat harus diisi',
                ]
            ],
            'isi_surat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Isi Surat harus diisi',
                ]
            ],
            'perihal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Perihal harus diisi',
                ]
            ],
            'kode' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kode harus diisi',
                ]
            ],
            'tgl_surat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Surat harus diisi',
                ]
            ],
            'file' => [
                'rules' => 'ext_in[file,pdf]|mime_in[file,application/pdf]',
                'errors' => [
                    'max_size' => 'File terlalu besar',
                    'ext_in' => 'File harus berformat PDF',
                    'mime_in' => 'File harus berformat PDF',
                ]
            ],
        ];
        if (!$this->validate($validation)) {
            // dd($validation);
            return redirect()->to('/administrasi/edit_surat_masuk/' . $input['id'])->withInput();
        }

        $file = $this->request->getFile('file');
        $file_lama = $this->surat_masuk->select('file')->where('id_surat', $input['id'])->first();
        if ($file->getError() == 4) {
            $nama_file = $file_lama->file;
        } else {

            $nama_file = $file->getName();
            $file->move('assets/uploads/document/surat_masuk');
            unlink('assets/uploads/document/surat_masuk/' . $file_lama->file);
        }

        $save = [
            'id_surat'      => $input['id'],
            'no_surat'      => $input['no_surat'],
            'asal_surat'    => $input['asal_surat'],
            'isi_surat'     => $input['isi_surat'],
            'perihal'     => $input['perihal'],
            'kode'          => $input['kode'],
            'tgl_surat'     => $input['tgl_surat'],
            'tgl_diterima'  => Time::today('Asia/Jakarta')->toDateString(),
            'file'          => $nama_file,
        ];

        if (!$this->surat_masuk->save($save)) {
            session()->setFlashdata('error', 'Data gagal disimpan');
            return redirect()->to('/administrasi/edit_surat/' . $input['id'])->withInput();
        }

        session()->setFlashdata('success', 'Data berhasil diubah');
        return redirect()->to('/administrasi/surat_masuk');
    }

    public function delete_surat_masuk()
    {
        $id = $this->request->getVar('id_surat');

        $surat = $this->surat_masuk->where('id_surat', $id)->first();

        unlink('assets/uploads/document/surat_masuk/' . $surat->file);
        if (!$this->surat_masuk->delete($id)) {
            session()->setFlashdata('error', 'Data gagal dihapus');
            return redirect()->to('/administrasi/surat_masuk');
        }


        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to('/administrasi/surat_masuk');
    }

    // Surat Keluar

    public function surat_keluar()
    {
        $search = $this->request->getVar('search');
        if ($search) {
            $surat_keluar = $this->surat_keluar->like('no_surat', $search)->orLike('tujuan', $search)
                ->orLike('isi_surat', $search)->findAll();
        } else {
            $surat_keluar = $this->surat_keluar->findAll();
        }

        $data = [
            'title' => 'Surat Keluar',
            'surat_keluar' => $surat_keluar,
        ];
        return view('administrasi/surat_keluar', $data);
    }

    public function add_surat_keluar()
    {
        $data = [
            'title' => 'Tambah Surat Keluar',
            'validation' => \Config\Services::validation(),
        ];
        return view('administrasi/add_surat_keluar', $data);
    }

    public function save_surat_keluar()
    {
        $input = $this->request->getVar();
        $validation = [
            'no_surat' => [
                'rules' => 'required|is_unique[surat_masuk.no_surat]',
                'errors' => [
                    'required' => 'No Surat harus diisi',
                    'is_unique' => 'No Surat sudah ada',
                ]
            ],
            'tujuan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Asal Surat harus diisi',
                ]
            ],
            'isi_surat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Isi Surat harus diisi',
                ]
            ],
            'kode' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kode harus diisi',
                ]
            ],
            'tgl_surat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Surat harus diisi',
                ]
            ],
            'file' => [
                'rules' => 'uploaded[file]|ext_in[file,pdf]|mime_in[file,application/pdf]',
                'errors' => [
                    'uploaded' => 'File harus diisi',
                    'max_size' => 'File terlalu besar',
                    'ext_in' => 'File harus berformat PDF',
                    'mime_in' => 'File harus berformat PDF',
                ]
            ],
        ];

        if (!$this->validate($validation)) {
            return redirect()->to('/administrasi/add_surat_keluar')->withInput();
        }

        $file = $this->request->getFile('file');
        $file->move('assets/uploads/document/surat_keluar');
        $nama_file = $file->getName();

        $save = [
            'no_surat'      => $input['no_surat'],
            'tujuan'    => $input['tujuan'],
            'isi_surat'     => $input['isi_surat'],
            'kode'          => $input['kode'],
            'tgl_surat'     => $input['tgl_surat'],
            'tgl_catat'  => Time::today('Asia/Jakarta')->toDateString(),
            'file'          => $nama_file,
        ];

        if (!$this->surat_keluar->save($save)) {
            session()->setFlashdata('error', 'Data gagal disimpan');
            return redirect()->to('/administrasi/add_surat_keluar')->withInput();
        }

        session()->setFlashdata('success', 'Data berhasil disimpan');
        return redirect()->to('/administrasi/surat_keluar');
    }

    public function view_surat_keluar($file)
    {
        $data = [
            'title' => 'Lihat Surat',
            'file' => $file,
        ];
        return view('administrasi/view_surat_keluar', $data);
    }

    public function edit_surat_keluar($id)
    {
        $surat = $this->surat_keluar->where('id_surat', $id)->first();
        // dd($surat);
        $data = [
            'title' => 'Edit Surat Keluar',
            'validation' => \Config\Services::validation(),
            'surat_keluar' => $surat,
        ];
        return view('administrasi/edit_surat_keluar', $data);
    }

    public function save_edit_surat_keluar()
    {
        $input = $this->request->getVar();
        // dd($input);
        $validation = [
            'no_surat' => [
                'rules' => 'required|',
                'errors' => [
                    'required' => 'No Surat harus diisi',
                ]
            ],
            'tujuan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Asal Surat harus diisi',
                ]
            ],
            'isi_surat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Isi Surat harus diisi',
                ]
            ],
            'kode' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kode harus diisi',
                ]
            ],
            'tgl_surat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Surat harus diisi',
                ]
            ],
            'file' => [
                'rules' => 'ext_in[file,pdf]|mime_in[file,application/pdf]',
                'errors' => [
                    'max_size' => 'File terlalu besar',
                    'ext_in' => 'File harus berformat PDF',
                    'mime_in' => 'File harus berformat PDF',
                ]
            ],
        ];
        if (!$this->validate($validation)) {
            // dd($validation);
            return redirect()->to('/administrasi/edit_surat_keluar/' . $input['id'])->withInput();
        }

        $file = $this->request->getFile('file');
        $file_lama = $this->surat_keluar->select('file')->where('id_surat', $input['id'])->first();
        if ($file->getError() == 4) {
            $nama_file = $file_lama->file;
        } else {

            $nama_file = $file->getName();
            $file->move('assets/uploads/document/surat_keluar');
            unlink('assets/uploads/document/surat_keluar/' . $file_lama->file);
        }

        $save = [
            'id_surat'      => $input['id'],
            'no_surat'      => $input['no_surat'],
            'tujuan'        => $input['tujuan'],
            'isi_surat'     => $input['isi_surat'],
            'kode'          => $input['kode'],
            'tgl_surat'     => $input['tgl_surat'],
            'tgl_catat'  => Time::today('Asia/Jakarta')->toDateString(),
            'file'          => $nama_file,
        ];

        if (!$this->surat_keluar->save($save)) {
            session()->setFlashdata('error', 'Data gagal disimpan');
            return redirect()->to('/administrasi/edit_surat_keluar/' . $input['id'])->withInput();
        }

        session()->setFlashdata('success', 'Data berhasil diubah');
        return redirect()->to('/administrasi/surat_keluar');
    }

    public function delete_surat_keluar()
    {
        $id = $this->request->getVar('id_surat');

        $surat = $this->surat_keluar->where('id_surat', $id)->first();

        unlink('assets/uploads/document/surat_keluar/' . $surat->file);
        if (!$this->surat_keluar->delete($id)) {
            session()->setFlashdata('error', 'Data gagal dihapus');
            return redirect()->to('/administrasi/surat_keluar');
        }


        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to('/administrasi/surat_keluar');
    }



    // DIGILIB

    public function digilib()
    {
        $search = $this->request->getVar('search');
        if ($search) {
            $buku = $this->digilib->like('judul', $search)->findAll();
        } else {
            $buku = $this->digilib->findAll();
        }
        $data = [
            'title'         => 'Digital Library',
            'validation'    => \Config\Services::validation(),
            'buku'          => $buku,
        ];
        return view('administrasi/digilib', $data);
    }

    public function add_book()
    {
        $data = [
            'title' => 'Tambah Buku',
            'validation' => \Config\Services::validation(),
        ];
        return view('administrasi/add_book', $data);
    }

    public function save_book()
    {
        $input = $this->request->getVar();
        $validation = [
            'judul' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No Surat harus diisi',
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Asal Surat harus diisi',
                ]
            ],
            'file' => [
                'rules' => 'uploaded[file]|ext_in[file,pdf]|mime_in[file,application/pdf]',
                'errors' => [
                    'uploaded' => 'File harus diisi',
                    'ext_in' => 'File harus berformat PDF',
                    'mime_in' => 'File harus berformat PDF',
                ]
            ],
        ];

        if (!$this->validate($validation)) {
            return redirect()->to('/administrasi/add_book')->withInput();
        }

        $file = $this->request->getFile('file');
        $file->move('assets/uploads/document/digilib');
        $nama_file = $file->getName();

        $save = [
            'judul'      => $input['judul'],
            'deskripsi'    => $input['deskripsi'],
            'file'          => $nama_file,
        ];

        if (!$this->digilib->save($save)) {
            session()->setFlashdata('error', 'Data gagal disimpan');
            return redirect()->to('/administrasi/add_book')->withInput();
        }

        session()->setFlashdata('success', 'Data berhasil disimpan');
        return redirect()->to('/administrasi/digilib');
    }

    public function view_buku($file)
    {
        $data = [
            'file' => $file
        ];
        return view('administrasi/view_buku', $data);
    }

    public function edit_buku()
    {
        $id = $this->request->getVar('id');
        $buku = $this->digilib->where('id', $id)->first();
        $data = [
            'title' => 'Edit Buku',
            'validation' => \Config\Services::validation(),
            'buku' => $buku
        ];
        return view('administrasi/edit_buku', $data);
    }

    public function save_edit_buku()
    {
        $input = $this->request->getVar();
        $validation = [
            'judul' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No Surat harus diisi',
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Asal Surat harus diisi',
                ]
            ],
            'file' => [
                'rules' => 'ext_in[file,pdf]|mime_in[file,application/pdf]',
                'errors' => [
                    'ext_in' => 'File harus berformat PDF',
                    'mime_in' => 'File harus berformat PDF',
                ]
            ],
        ];
        if (!$this->validate($validation)) {
            // dd($validation);
            return redirect()->to('/administrasi/edit_buku')->withInput();
        }

        $file = $this->request->getFile('file');
        $file_lama = $this->digilib->select('file')->where('id', $input['id'])->first();
        if ($file->getError() == 4) {
            $nama_file = $file_lama->file;
        } else {
            $nama_file = $file->getName();
            $file->move('assets/uploads/document/digilib');
            unlink('assets/uploads/document/digilib/' . $file_lama->file);
        }

        $save = [
            'id'      => $input['id'],
            'judul'      => $input['judul'],
            'deskripsi'    => $input['deskripsi'],
            'file'          => $nama_file,
        ];

        if (!$this->digilib->save($save)) {
            session()->setFlashdata('error', 'Data gagal disimpan');
            return redirect()->to('/administrasi/edit_buku')->withInput();
        }

        session()->setFlashdata('success', 'Data berhasil diubah');
        return redirect()->to('/administrasi/digilib');
    }

    public function delete_buku()
    {
        $id = $this->request->getVar('id');
        $file = $this->digilib->select('file')->where('id', $id)->first();
        unlink('assets/uploads/document/digilib/' . $file->file);
        if (!$this->digilib->delete($id)) {
            session()->setFlashdata('error', 'Data gagal dihapus');
            return redirect()->to('/administrasi/digilib');
        }
        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to('/administrasi/digilib');
    }
}
