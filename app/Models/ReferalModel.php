<?php

namespace App\Models;

use CodeIgniter\Model;

class ReferalModel extends Model
{
    protected $table = 'referal';
    protected $primaryKey = 'nomor_anggota';
    protected $allowedFields = ['referal','nomor_anggota'];

    public function getReferal()
    {
        return $this->db->table('referal')
            ->join('data_anggota', 'data_anggota.nomor_anggota=referal.nomor_anggota')
            // ->join('calon_anggota', 'calon_anggota.kode_referal=referal.kode_referal')
            // // ->groupBy('calon_anggota.kode_referal')
            ->get()->getResultArray();
    }

    // public function getCountReferal($ref)
    // {
    //     $prep = $db->table('calon_anggota');
    //     $prep = $
    // }
}
