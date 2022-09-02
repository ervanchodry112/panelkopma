<?php

namespace App\Models;

use CodeIgniter\Model;

class SimpananModel extends Model
{
    public function getSimpanan()
    {
        return $this->db->table('data_simpanan')
            ->join('data_anggota', 'data_simpanan.npm=data_anggota.npm')
            ->get()->getResultArray();
    }
}
