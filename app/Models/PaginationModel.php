<?php

namespace App\Models;

use CodeIgniter\Model;

class PaginationModel extends Model
{
    protected $table = 'testimonies_detail';

    public function count_all()
    {
        return $this->countAll();
    }

    public function get_paginated($limit, $start)
    {
        return $this->orderBy('tanggal', 'DESC')
                    ->findAll($limit, $start);
    }
}