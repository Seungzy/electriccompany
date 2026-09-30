<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginAccountModel extends Model
{
    protected $table = 'user_accounts';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['username', 'password'];
}
