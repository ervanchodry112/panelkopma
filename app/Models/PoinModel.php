<?php

namespace App\Models;

use CodeIgniter\Model;

class PoinModel extends Model
{
    public function getPoin()
    {
        return $this->db->table('data_poin')
            ->join('data_anggota', 'data_anggota.nomor_anggota=data_poin.nomor_anggota')
            ->join('data_simpanan', 'data_simpanan.npm=data_anggota.npm')
            ->get()->getResultArray();
    }
}
