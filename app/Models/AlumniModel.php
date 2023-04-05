<?php

namespace App\Models;

use CodeIgniter\Model;

class AlumniModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'alumni';
    protected $primaryKey       = 'id_alumni';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = AlumniModel::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_alumni', 'email_alumni', 'no_hp_alumni', 'alamat_alumni', 'status_alumni', 'tahun_lulus', 'slug_alumni'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getAlumni($slug = false)
    {
        if (!$slug) {
            return $this->findAll();
        }

        return $this->where(['slug_alumni' => $slug])->first();
    }

    public function create_slug($name = false){
        if(!$name){
            return false;
        }
        $slug = url_title($name, '-', true);
        if(!$this->check_slug_available($slug)){
            return false;
        }
        return $slug;
    }

    public function check_slug_available($slug){
        $data = $this->where(['slug_alumni' => $slug])->first();
        if($data){
            return false;
        }else{
            return true;
        }
    }
}
