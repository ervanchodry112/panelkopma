<?php

namespace App\Models;

use CodeIgniter\Model;

class SimpananModel extends Model
{
    protected $table = 'data_simpanan';
    protected $primaryKey = 'npm';
    public $timestamps = false;
}
