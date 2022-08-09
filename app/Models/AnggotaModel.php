<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table = 'data_anggota';
    protected $primaryKey = 'npm';
    protected $useAutoIncrement = false;
}
