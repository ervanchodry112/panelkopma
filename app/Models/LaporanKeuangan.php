<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanKeuangan extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'laporan_keuangan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = LaporanKeuangan::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['judul', 'file', 'bulan', 'tahun'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
