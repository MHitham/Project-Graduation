<?php

namespace App\Services\Auth;

use Illuminate\Http\Request;

interface IAuthService
{
    public function register($request);
    public function login(Request $request);
    public function login2fa($request);
    public function verifyEmail($request);
    public function resendEmailVerificationCode($request);
    public function logout();
    public function forgetPassword($request);
    public function resetPassword($request);
}
