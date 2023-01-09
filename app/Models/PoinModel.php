<?php

namespace App\Models;

use CodeIgniter\Model;

class PoinModel extends Model
{
    protected $table = 'data_poin';
    protected $primaryKey = 'nomor_anggota';
    protected $allowedFields = ['nomor_anggota', 'poin'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


    public function getPoin()
    {
        return $this->db->table('data_poin')
            ->join('data_anggota', 'data_anggota.nomor_anggota=data_poin.nomor_anggota')
            ->join('data_simpanan', 'data_simpanan.nomor_anggota=data_anggota.nomor_anggota')
            ->select('data_poin.poin, data_anggota.nomor_anggota, data_anggota.nama_lengkap, data_anggota.nomor_anggota, data_simpanan.simpanan_wajib')
            ->get()->getResultArray();
    }
}
