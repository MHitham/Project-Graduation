<?php

namespace App\Services;

use App\Classes\ValidatorClass;
use App\Models\User;
use App\Repositories\Auth\IAuthRepository;
use App\Services\EmailService\IEmailService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class EmailService implements IEmailService
{
    private IAuthRepository $_authRepository;
    public function __construct(IAuthRepository $_authRepository)
    {
        $this->_authRepository = $_authRepository;
    }
    public function resendEmailVerificationLink(Request $request){
        $validator = $this->validate_resend_email_verification_link($request);
        if($validator['status'] && $this->_authRepository->existsByEmail($request->email)){
            $user = User::where('email', $request->email)->first();
            if($user != null){
                if($user->is_email_verified){
                    return response()->json([
                        'status'=>false,
                        'message'=>'email already verified'
                    ], 403);
                }
                $user->sendEmailVerificationNotification();
                return response()->json([
                    'status'=>true,
                    'message'=>'email sent successfully'
                ], 200);
            }
        }
        return $validator['errors'];
    }
    private function validate_resend_email_verification_link(Request $request){
        $validator = Validator::make($request->all(), [
            'email'=>['required']
        ]);
        return ValidatorClass::checkValidator($validator);
    }
}
