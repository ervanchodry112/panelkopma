<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratMasukModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'surat_masuk';
    protected $primaryKey       = 'id_surat';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = SuratMasukModel::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_surat', 'no_surat', 'asal_surat', 'isi_surat', 'perihal', 'kode', 'indeks', 'tgl_surat', 'tgl_diterima', 'file', 'keterangan'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
