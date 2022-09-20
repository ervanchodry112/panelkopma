<?php

namespace App\Models;

use CodeIgniter\Model;

class SimpananModel extends Model
{
    protected $table = 'data_simpanan';
    protected $primaryKey = 'npm';
    protected $allowedFields = ['npm', 'simpanan_pokok', 'simpanan_wajib', 'total_simpanan'];
    
    public function getSimpanan()
    {
        return $this->db->table('data_simpanan')
            ->join('data_anggota', 'data_simpanan.npm=data_anggota.npm')
            ->get()->getResultArray();
    }
}
