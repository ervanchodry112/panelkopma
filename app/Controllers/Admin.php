<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;

class Admin extends BaseController
{
    protected $data_user;

    public function __construct()
    {
        $this->data_user = new UserModel;
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
        $data = [
            'title' => 'Tambah User',
            'validation' => \Config\Services::validation()
        ];

        return view('/auth/register', $data);
    }
}
