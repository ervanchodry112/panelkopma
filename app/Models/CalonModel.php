<?php

namespace App\Models;

use CodeIgniter\Model;

class CalonModel extends Model
{
    public function getCalonAnggota()
    {
        return $this->db->table('calon_anggota')
            ->join('jurusan', 'calon_anggota.id_jurusan=jurusan.id_jurusan')
            ->join('fakultas', 'jurusan.id_fakultas=fakultas.id_fakultas')
            ->join('asal_informasi', 'calon_anggota.asal_informasi=asal_informasi.id_informasi')
            ->get()->getResultArray();
    }
}
