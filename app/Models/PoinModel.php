<?php

namespace App\Models;

use CodeIgniter\Model;

class PoinModel extends Model
{
    protected $table = 'poin';
    protected $primaryKey = 'id_poin';
    public $timestamps = false;
    protected $fillable = ['id_poin', 'id_user', 'poin', 'tanggal'];
}
