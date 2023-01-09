<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanModel extends Model
{
    protected $table = 'data_kegiatan';
    protected $primaryKey = 'id_kegiatan';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['id_kegiatan', 'nama_kegiatan', 'tanggal_kegiatan', 'tempat_kegiatan'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getKegiatan($id = false)
    {
        if (!$id) {
            return $this->findAll();
        }
        return $this->where(['id_kegiatan' => $id])->first();
    }
}
