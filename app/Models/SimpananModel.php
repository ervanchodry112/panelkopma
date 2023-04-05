<?php

namespace App\Models;

use CodeIgniter\Model;

class SimpananModel extends Model
{
    protected $table = 'data_simpanan';
    protected $primaryKey = 'nomor_anggota';
    protected $allowedFields = ['nomor_anggota', 'simpanan_pokok', 'simpanan_wajib', 'tagihan'];


    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    
    public function getSimpanan()
    {
        return $this->db->table('data_simpanan')
            ->join('data_anggota', 'data_simpanan.nomor_anggota=data_anggota.nomor_anggota')
            ->get()->getResultArray();
    }
}
