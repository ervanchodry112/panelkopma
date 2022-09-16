<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table = 'data_anggota';
    protected $primaryKey = 'npm';
    protected $useAutoIncrement = 'false';
    protected $useSoftDeletes = 'true';
    protected $allowedFields = [
        'npm', 'nomor_anggota', 'nama_lengkap', 'email',
        'nomor_hp', 'id_jurusan'
    ];
}
