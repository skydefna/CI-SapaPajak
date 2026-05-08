<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfileModel extends Model
{
    public function getUserRole()
    {
        return $this->db->table('user_role')->get()->getResultArray();
    }
}