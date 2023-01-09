<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramKerja extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'program_kerja';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = ProgramKerja::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_program', 'deskripsi', 'rencana_pelaksanaan', 'user', 'tahun', 'lpj', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
