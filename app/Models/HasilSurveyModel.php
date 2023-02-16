<?php

namespace App\Models;

use CodeIgniter\Model;

class HasilSurveyModel extends Model
{
    protected $table            = 'hasil_survey';
    protected $primaryKey       = 'id_laporan';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'id_laporan', 'nama_survey', 'deskripsi', 'tanggal_mulai', 'tanggal_selesai',
        'file', 'jumlah_responden',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
