<?php

namespace App\Models;

use CodeIgniter\Model;

class Presensi extends Model
{
    protected $table            = 'presensi';
    protected $primaryKey       = 'id_presensi';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['waktu', 'id_data', 'id_kegiatan'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getPresensi($id_kegiatan = false)
    {
        if (!$id_kegiatan) {
            return $this->findAll();
        }
        return $this->db->table('presensi')
            ->join('data_anggota', 'data_anggota.npm=presensi.id_data')
            ->join('data_kegiatan', 'data_kegiatan.id_kegiatan=presensi.id_kegiatan')
            ->where('presensi.id_kegiatan', $id_kegiatan)
            ->get()->getResultArray();
    }
}
