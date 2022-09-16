<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranSimwa extends Model
{
    protected $table = 'pembayaran_simwa';
    protected $primaryKey = 'id_pembayaran';
    protected $allowedFields = ['id_pembayaran', 'nomor_anggota', 'nominal', 'created_at', 'status', 'bukti_pembayaran'];
    protected $autoIncrement = false;

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getPembayaran()
    {
        return $this->db->table('pembayaran_simwa')
            ->join('data_anggota', 'data_anggota.nomor_anggota=pembayaran_simwa.nomor_anggota')
            ->get()->getResultArray();
    }
}
