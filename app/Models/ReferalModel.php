<?php

namespace App\Models;

use CodeIgniter\Model;

class ReferalModel extends Model
{
    protected $table = 'referal';
    protected $primaryKey = 'kode_referal';
    protected $allowedFields = ['kode_referal', 'nomor_anggota'];
}
