<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupUserModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'auth_groups';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['group_id', 'user_id'];


    public function saveGroup($user_id, $group_id)
    {
        $data = [
            'user_id' => $user_id,
            'group_id' => $group_id
        ];
        return $this->db->table('auth_groups_users')->insert($data);
    }

    public function getGroup()
    {
        return $this->db->table('auth_groups')->get()->getResultObject();
    }

    public function deleteFromGroup($id_user)
    {
        return $this->db->table('auth_groups_users')->delete(['user_id' => $id_user]);
    }
}
