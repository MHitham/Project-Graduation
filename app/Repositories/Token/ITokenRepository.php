<?php

namespace App\Repositories\Token;

interface ITokenRepository
{
    public function saveToken($token, $user_id, $expires_at);
    public function deleteTokenByToken($token);
    public function deleteTokenByUserID($user_id);
    public function isTokenExists($token);
    public function isUserHasToken($user_id);
}
