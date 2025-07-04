<?php

namespace App\Repositories\Roles;

interface IUserRolesRepository
{
    public function addToUser($user_id, $role_id);
    public function deleteFromUser($user_id, $role_id);
    public function isUserInRole($user_id, $role_id);
}
