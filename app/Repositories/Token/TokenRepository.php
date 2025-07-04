<?php

namespace App\Repositories\Token;

use App\Models\LoginTokens;

class TokenRepository implements ITokenRepository
{
    public function saveToken($token, $user_id, $expires_at){
        if(!$this->isUserHasToken($user_id)){
            LoginTokens::create([
                'user_id'=>$user_id,
                'token'=>$token,
                'expires_at'=>$expires_at
            ]);
        }
        return $this->isTokenExists($token);
    }
    public function deleteTokenByToken($token){
        if($this->isTokenExists($token)){
            LoginTokens::where('token', $token)->delete();
        }
        return !$this->isTokenExists($token);
    }
    public function deleteTokenByUserID($user_id){
        if($this->isUserHasToken($user_id)){
            LoginTokens::where('user_id', $user_id)->delete();
        }
        return !$this->isUserHasToken($user_id);
    }
    public function isTokenExists($token){
        return LoginTokens::where('token', $token)->exists();
    }
    public function isUserHasToken($user_id){
        return LoginTokens::where('user_id', $user_id)->exists();
    }
}
