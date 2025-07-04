<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Repositories\Icrud;

interface IAuthRepository
{
    public function existsByEmail($email);             
    public function existsByUserName($username);  
    public function existsById($id);
}
