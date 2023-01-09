<?php

namespace App\Models;

use CodeIgniter\Model;

class SiJukoAccount extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'akun';
    protected $primaryKey       = 'nomor_anggota';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = SiJukoAccount::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nomor_anggota', 'username', 'password'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
