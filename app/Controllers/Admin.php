<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GroupUserModel;
use App\Models\SiJukoAccount;
use Myth\Auth\Models\UserModel;

class Admin extends BaseController
{
    protected $data_user;
    protected $group;
    protected $akun;

    public function __construct()
    {
        $this->data_user = new UserModel();
        $this->group = new GroupUserModel();
        $this->akun = new SiJukoAccount();
        if (!in_groups('admin')) {
            return redirect()->to('/dashboard');
        }
    }
    public function index()
    {
        return redirect()->to('/admin/data_user');
    }

    public function data_user()
    {
        $user = $this->data_user->join('auth_groups_users', 'auth_groups_users.user_id=users.id')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')->paginate(10, 'users');
        $data = [
            'title' => 'Data User',
            'user' => $user,
            'pager' => $this->data_user->pager,
        ];

        return view('/dashboard/data_user', $data);
    }

    public function add_user()
    {
        $group_list = $this->group->getGroup();

        $data = [
            'title' => 'Tambah User',
            'validation' => \Config\Services::validation(),
            'role' => $group_list,
        ];

        return view('/auth/register', $data);
    }

    public function reset_password()
    {
        $user = $this->data_user->where('username', $this->request->getVar('id'))->first();
        // dd($user->id);
        $data = [
            'title' => 'Reset Password',
            'validation' => \Config\Services::validation(),
            'user' => $user
        ];

        return view('/auth/reset_password', $data);
    }

    public function attempt_reset()
    {
        // dd($this->request->getVar());
        $new = $this->request->getVar();
        $validation = [
            'password' => [
                'rules' => 'required|min_length[4]',
                'errors' => [
                    'required' => 'Password harus diisi.',
                    'min_length' => 'Password minimal 4 karakter.'
                ]
            ],
            'pass_confirm' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirm password harus diisi.',
                ],
            ],
        ];
        // dd($new);

        if (!$this->validate($validation)) {
            // dd('gagal validasi');
            echo '<script>alert("Gagal validasi")</script>';
            return redirect()->to('/admin/reset_password')->withInput();
        }
        // dd($new);
        $reset = [
            'id' => $new['id'],
            'password_hash' => password_hash($new['password'], PASSWORD_DEFAULT),
        ];
        if (!$this->data_user->save($reset)) {
            dd("gagal");
            session()->setFlashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal!</strong> Password gagal direset.
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>');
            return redirect()->to('/admin/reset_password')->withInput();
        }
        session()->setFlashdata('pesan', '<strong>Berhasil!</strong> Password berhasil direset.');
        return redirect()->to('/admin/data_user');
    }

    public function delete_user()
    {
        $id = $this->request->getVar('id');
        $this->group->deleteFromGroup($id);
        if (!$this->data_user->delete($id)) {
            session()->setFlashdata('pesan', '<strong>Gagal!</strong> User gagal dihapus.');
            return redirect()->to('/admin/data_user');
        }
        session()->setFlashdata('pesan', '<strong>Berhasil!</strong> User berhasil dihapus.');
        return redirect()->to('/admin/data_user');
    }

    public function register()
    {
        $akun = $this->request->getVar();
        $validation = [
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email harus diisi.',
                    'valid_email' => 'Email tidak valid.',
                    'is_unique' => 'Email sudah terdaftar.'
                ]
            ],
            'username' => [
                'rules' => 'required|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username harus diisi',
                    'is_unique' => 'Username sudah terdaftar',
                ],
            ],
            'password' => [
                'rules' => 'required|min_length[4]',
                'errors' => [
                    'required' => 'Password harus diisi.',
                    'min_length' => 'Password minimal 4 karakter.'
                ],
            ],
            'pass_confirm' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password harus diisi.',
                    'matches' => 'Password tidak sama.',
                ],
            ],
            'role' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Role harus dipilih.',
                ],
            ],
        ];

        if (!$this->validate($validation)) {
            return redirect()->to('/admin/add_user')->withInput();
        }

        $data = [
            'email' => $akun['email'],
            'username' => $akun['username'],
            'password_hash' => password_hash($akun['password'], PASSWORD_DEFAULT),
            'active' => 1,
        ];

        if (!$this->data_user->save($data)) {
            session()->setFlashdata('pesan', '<strong>Gagal!</strong> User gagal ditambahkan.');
            return redirect()->to('/admin/add_user');
        }

        $user = $this->data_user->where('email', $akun['email'])->first();


        if (!$this->group->saveGroup($user->id, $akun['role'])) {
            $this->data_user->delete($user->id);
            session()->setFlashdata('pesan', '<strong>Gagal!</strong> User gagal ditambahkan.');
            return redirect()->to('/admin/data_user');
        }

        session()->setFlashdata('pesan', '<strong>Berhasil!</strong> User berhasil ditambahkan.');
        return redirect()->to('/admin/data_user');
    }

    public function akun_juko()
    {
        $data = [
            'title' => 'Akun Si Juko',
        ];

        return view('dashboard/akun_juko', $data);
    }
}
