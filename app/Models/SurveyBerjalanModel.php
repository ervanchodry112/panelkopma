<?php

namespace App\Models;

use CodeIgniter\Model;

class SurveyBerjalanModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'survey_berjalan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = SurveyBerjalanModel::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_survey', 'deskripsi', 'tgl_mulai', 'tgl_selesai', 'link'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

}
