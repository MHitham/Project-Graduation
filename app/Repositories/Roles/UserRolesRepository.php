<?php

namespace App\Repositories\Roles;

use App\Models\UserRoles;

class UserRolesRepository implements IUserRolesRepository
{
    public function addToUser($user_id, $role_id){
        if(!$this->isUserInRole($user_id, $role_id)){
            UserRoles::create([
                'user_id'=>$user_id,
                'role_id'=>$role_id
            ]);
            return $this->isUserInRole($user_id, $role_id);
        }
        return false;
    }
    public function deleteFromUser($user_id, $role_id){
        if($this->isUserInRole($user_id, $role_id)){
            UserRoles::where([
                'user_id'=>$user_id,
                'role_id'=>$role_id
            ])->delete();
        }
        return !$this->isUserInRole($user_id, $role_id);
    }
    public function isUserInRole($user_id, $role_id){
        return UserRoles::where([
            'user_id'=>$user_id,
            'role_id'=>$role_id
        ])->exists();
    }
}
