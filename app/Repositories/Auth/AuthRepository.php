<?php

namespace App\Repositories\Auth;

use App\Models\User;

class AuthRepository implements IAuthRepository
{
    public function existsById($id){
        return User::where('id', $id)->exists();
    }
    public function existsByEmail($email){
        return User::where('email', $email)->exists();
    }     

    public function existsByUserName($username){
        return User::where('username', $username)->exists();
    }      
}
