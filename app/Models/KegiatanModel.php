<?php

namespace App\Models;
use CodeIgniter\Model;

class KegiatanModel extends Model
{
    protected $table = 'data_kegiatan';
    protected $primaryKey = 'id_kegiatan';
    protected $useAutoIncrement = false;
}
