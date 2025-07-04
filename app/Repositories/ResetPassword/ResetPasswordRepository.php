<?php

namespace App\Repositories\ResetPassword;

use App\Models\ResetPassword;

class ResetPasswordRepository implements IResetPasswordRepository
{
    public function saveCode($code, $user_id, $expires_at){
        if(!$this->isUserHasCode($user_id)){
            ResetPassword::create([
                'user_id'=>$user_id,
                'code'=>$code,
                'expires_at'=>$expires_at
            ]);
        }
        return $this->isUserHasCode($user_id);
    }
    public function deleteCodeByUserID($user_id){
        if($this->isUserHasCode($user_id)){
            ResetPassword::where('user_id', $user_id)->delete();
        }
        return !$this->isUserHasCode($user_id);
    }
    public function isCodeExists($user_id, $code){
        if($this->isUserHasCode($user_id)){
            return ResetPassword::where([
                'user_id'=> $user_id,
                'code'=>$code
            ])->exists();    
        }
        return false;
    }
    public function getByUserID($user_id){
        if($this->isUserHasCode($user_id)){
            return ResetPassword::where([
                'user_id'=> $user_id,
            ])->first();    
        }
        return null;
    }
    public function isUserHasCode($user_id){
        return ResetPassword::where('user_id', $user_id)->exists();
    }
}
