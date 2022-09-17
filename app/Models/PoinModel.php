<?php

namespace App\Models;

use CodeIgniter\Model;

class PoinModel extends Model
{
    protected $table = 'data_poin';
    protected $primaryKey = 'nomor_anggota';
    protected $allowedFields = ['nomor_anggota', 'poin'];
    protected $useTimestamps = false;


    public function getPoin()
    {
        return $this->db->table('data_poin')
            ->join('data_anggota', 'data_anggota.nomor_anggota=data_poin.nomor_anggota')
            ->join('data_simpanan', 'data_simpanan.npm=data_anggota.npm')
            ->get()->getResultArray();
    }
}
