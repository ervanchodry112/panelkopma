<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranSimwa extends Model
{
    public function getPembayaran()
    {
        return $this->db->table('pembayaran_simwa')
            ->join('data_anggota', 'data_anggota.nomor_anggota=pembayaran_simwa.nomor_anggota')
            ->get()->getResultArray();
    }
}
