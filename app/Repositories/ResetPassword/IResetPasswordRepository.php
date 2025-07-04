<?php

namespace App\Repositories\ResetPassword;

interface IResetPasswordRepository
{
    public function saveCode($code, $user_id, $expires_at);
    public function deleteCodeByUserID($user_id);
    public function isCodeExists($user_id, $code);
    public function isUserHasCode($user_id);
    public function getByUserID($user_id);
}
