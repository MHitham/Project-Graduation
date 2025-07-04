<?php

namespace App\Services\EmailService;
use Illuminate\Http\Request;


interface IEmailService
{
    public function resendEmailVerificationLink(Request $request);
}
