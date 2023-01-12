<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProdukModel;

class Usaha extends BaseController
{
    protected $produk_model;

    public function __construct()
    {
        $this->produk_model = new ProdukModel();
    }

    public function produk()
    {
        $search = $this->request->getVar('search');

        if ($search) {
            $produk = $this->produk_model->like('nama_produk', $search)->findAll();
        } else {
            $produk = $this->produk_model->findAll();
        }
        $data = [
            'title' => 'Produk',
            'produk' => $produk,
        ];

        return view('usaha/produk', $data);
    }

    public function add_produk()
    {
        $data = [
            'title' => 'Tambah Produk',
            'validation' => \Config\Services::validation(),
        ];

        return view('usaha/add_produk', $data);
    }

    public function save_produk()
    {
        $input = $this->request->getVar();

        $validation = [
            'nama_produk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama produk harus diisi',
                ]
            ],
            'harga_produk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harga produk harus diisi',
                ]
            ],
            'file' => [
                'rules' => 'uploaded[file]|ext_in[file,png,jpg,jpeg]|mime_in[file,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'uploaded' => 'Gambar harus diisi',
                    'mime_in' => 'Format gambar tidak sesuai',
                    'ext_in' => 'Format gambar tidak sesuai',
                ]
            ],
        ];

        if (!$this->validate($validation)) {
            return redirect()->to('usaha/add_produk')->withInput();
        }

        $file = $this->request->getFile('file');
        $nama = $file->getRandomName();
        $file->move('assets/uploads/img/produk', $nama);

        $save = [
            'nama_produk' => $input['nama_produk'],
            'harga_produk' => $input['harga_produk'],
            'gambar_produk' => $nama,
        ];

        if (!$this->produk_model->save($save)) {
            session()->setFlashdata('error', 'Gagal menambah data');
            return redirect()->to('usaha/add_produk')->withInput();
        }

        session()->setFlashdata('success', 'Berhasil menambahkan data');
        return redirect()->to('usaha/produk');
    }

    public function edit_produk($id)
    {
        $produk = $this->produk_model->where('id_produk', $id)->first();
        $data = [
            'title' => 'Edit Produk',
            'validation' => \Config\Services::validation(),
            'produk' => $produk,
        ];
        return view('usaha/edit_produk', $data);
    }

    public function save_update_produk()
    {
        $input = $this->request->getVar();

        $validation = [
            'nama_produk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama produk harus diisi',
                ]
            ],
            'harga_produk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harga produk harus diisi',
                ]
            ],
            'file' => [
                'rules' => 'ext_in[file,png,jpg,jpeg]|mime_in[file,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'mime_in' => 'Format gambar tidak sesuai',
                    'ext_in' => 'Format gambar tidak sesuai',
                ]
            ],
        ];

        if (!$this->validate($validation)) {
            return redirect()->to('usaha/add_produk/' . $input['id_produk'])->withInput();
        }

        $file = $this->request->getFile('file');
        $file_lama = $this->produk_model->select('gambar_produk')->where('id_produk', $input['id_produk'])->first();
        if ($file->getError() == 4) {
            $nama_file = $file_lama->gambar_produk;
        } else {
            $nama_file = $file->getRandomName();
            $file->move('assets/uploads/img/produk', $nama_file);
            unlink('assets/uploads/img/produk/' . $file_lama->gambar_produk);
        }

        $save = [
            'id_produk' => $input['id_produk'],
            'nama_produk' => $input['nama_produk'],
            'harga_produk' => $input['harga_produk'],
            'gambar_produk' => $nama_file,
        ];

        if (!$this->produk_model->save($save)) {
            session()->setFlashdata('error', 'Gagal menyimpan data');
            return redirect()->to('usaha/add_produk')->withInput();
        }

        session()->setFlashdata('success', 'Berhasil menyimpan data');
        return redirect()->to('usaha/produk');
    }

    public function delete_produk()
    {
        $id = $this->request->getVar('id_produk');
        $file_lama = $this->produk_model->select('gambar_produk')->where('id_produk', $id)->first();

        unlink('assets/uploads/img/produk/' . $file_lama->gambar_produk);
        if (!$this->produk_model->where('id_produk', $id)->delete()) {
            session()->setFlashdata('error', 'Gagal menghapus data');
            return redirect()->to('usaha/produk');
        }

        session()->setFlashdata('success', 'Berhasil menghapus data');
        return redirect()->to('usaha/produk');
    }
}
