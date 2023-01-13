<?php

namespace App\Models;

use CodeIgniter\Model;

class CalonModel extends Model
{
    protected $table = 'calon_anggota';
    protected $primaryKey = 'npm';
    protected $allowedFields = [
        'npm', 'nama_lengkap', 'jurusan', 'fakultas', 'kode_referal', 'email', 'nomor_hp', 'domisili',
        'alasan', 'asal_informasi', 'nama_panggilan', 'tanggal_lahir', 'tempat_lahir', 'foto', 'ktm', 'bukti_pembayaran', 'jenis_kelamin'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
