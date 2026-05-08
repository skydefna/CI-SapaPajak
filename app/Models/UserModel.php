<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'username',
        'password',
        'role_id',
        'is_active',
        'image',
        'jabatan',
        'nip',
        'ditemui',
        'date_created'
    ];

    protected $returnType = 'array';
}