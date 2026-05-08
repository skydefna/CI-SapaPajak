<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    public function getSubMenu()
    {
        return $this->db->table('user_sub_menu')
            ->select('user_sub_menu.*, user_menu.menu')
            ->join('user_menu', 'user_sub_menu.menu_id = user_menu.id')
            ->where('user_sub_menu.url IS NOT NULL')
            ->whereNotIn('user_sub_menu.id', [1,2,4,5,7,20])
            ->get()
            ->getResultArray();
    }

    public function getUsers()
    {
        return $this->db->table('user')
            ->select('user.*, user_role.role')
            ->join('user_role', 'user.role_id = user_role.id')
            ->get()
            ->getResultArray();
    }
}