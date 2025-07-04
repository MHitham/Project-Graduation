<?php

namespace App\Services\Auth;

use App\Models\VerifyEmails;
use App\Repositories\Auth\IAuthRepository;
use App\Classes\ValidatorClass;
use App\Mail\ResetPasswordMail;
use App\Mail\TwoFactorMail;
use App\Mail\VerifyMail;
use App\Models\Roles;
use App\Models\TwoFactorAuth;
use App\Models\User;
use App\Repositories\ResetPassword\IResetPasswordRepository;
use App\Repositories\Roles\IUserRolesRepository;
use App\Repositories\Token\ITokenRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AuthService implements IAuthService
{
    private IAuthRepository $authRepository;
    private IResetPasswordRepository $resetPasswordRepository;
    private IUserRolesRepository $userRolesRepository;
    private ITokenRepository $tokenRepository;
    public function __construct(IAuthRepository $authRepository, ITokenRepository $tokenRepository,
    IResetPasswordRepository $resetPasswordRepository, IUserRolesRepository $userRolesRepository){
        $this->authRepository = $authRepository;
        $this->tokenRepository = $tokenRepository;
        $this->resetPasswordRepository = $resetPasswordRepository;
        $this->userRolesRepository = $userRolesRepository;
    }
    public function register($request){
        $validator =$this->validateRegisterRequest($request);
        if($validator['status'] == false){
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator['errors']
            ], 422);
        }
        if($this->authRepository->existsByEmail($request->email)){
            return response()->json([
                'status' => false,
                'message' => 'email already exists',
            ], 500);
        }
        DB::beginTransaction();
        $isUserCreated = $this->createUserWithRole($request);
        $sendEmail = $this->sendEmailVerificationCode($request->email);
        if($sendEmail && $isUserCreated){
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Registered successfully check inbox to verify your email',
            ], 201);
        }
        DB::rollBack();
        return response()->json([
            'status' => false,
            'message' => 'failed to register',
        ], 500);
        
    }

    public function verifyEmail($request){
        $validator =$this->validateVerifyEmailRequest($request);
        if($validator['status'] == false){
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator['errors']
            ], 422);
        }
        if($this->authRepository->existsByEmail($request->email)){
            $user = User::where('email', $request->email)->first();
            if(!$user->is_email_verified){
                $verify = VerifyEmails::where('user_id',$user->id)->first();
                $current_date = date('Y-m-d H:i:s');
                if($current_date < $verify->expired_at && $verify->code == $request->code){
                    DB::beginTransaction();
                    $deleteVerifyCode = VerifyEmails::where('user_id',$user->id)->delete();
                    $updateUser = User::where('id', $user->id)->update([
                        'is_email_verified'=>1,
                        'email_verified_at'=>date('Y-m-d H:i:s'),
                        'is_two_factor_enabled'=>1
                    ]);
                    if($deleteVerifyCode&&$updateUser){
                        DB::commit();
                        return response()->json([
                            'status'=>true,
                            'message'=>'email verified successfully'
                        ], 200);
                    }
                    else DB::rollBack();
                }
            }
        }
        return response()->json([
            'status'=>false,
            'message'=>'failed to verify email'
        ], 500);
    }

    public function resendEmailVerificationCode($request){
        $validator =$this->validateResendVerifyEmailRequest($request);
        if($validator['status'] == false){
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator['errors']
            ], 422);
        }
        if($this->authRepository->existsByEmail($request->email)){
            $user = User::where('email', $request->email)->first();
            if(!$user->is_email_verified){
                $sentVerification = VerifyEmails::where('user_id', $user->user_id)->first();
                $current_date = date('Y-m-d H:i:s');
                if($current_date > $sentVerification->expired_at){
                    VerifyEmails::where('user_id', $user->user_id)->delete();
                    $this->sendEmailVerificationCode($user->email);
                    return response()->json([
                        'status'=>true,
                        'message'=>'email verification resent successfully'
                    ], 200);
                }
                return response()->json([
                    'status'=>false,
                    'message'=>'we have already sent email verification to you'
                ], 403);
            }
            return response()->json([
                'status'=>false,
                'message'=>'email already verified'
            ], 403);
        }
        return response()->json([
            'status'=>false,
            'message'=>'failed to sent email'
        ], 500);
    }

    public function login(Request $request){
        $validator =$this->validateLoginRequest($request);
        if($validator['status'] == false){
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator['errors']
            ], 422);
        }
        if($this->authRepository->existsByEmail($request->email)){
            $user = User::where('email', $request->email)->first();
            $verify = TwoFactorAuth::where('user_id',$user->id)->first();
            if($verify != null){
                TwoFactorAuth::where('user_id',$user->id)->delete();
            }
            if(!Hash::check($request->password, $user->password)){
                return response()->json([
                    'status' => false,
                    'message' => 'invalid email or password',
                ], 400);
            }
            $sendCode = $this->sendTwoFactorCode($request->email);
            if($sendCode){
                return response()->json([
                    'status' => true,
                    'message' => 'two factor code sent to your email check your inbox',
                ], 200);
            }
            return response()->json([
                'status' => false,
                'message' => 'failed to send two factor code',
            ], 500);
        }
        return response()->json([
            'status' => false,
            'message' => 'invalid email or password',
        ], 400);
    }

    public function login2fa($request){
        $validator =$this->validate2faLoginRequest($request);
        if($validator['status'] == false){
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator['errors']
            ], 422);
        }
        if($this->authRepository->existsByEmail($request->email)){
            $user = User::where('email', $request->email)->first();
            if($user->is_email_verified){
                $verify = TwoFactorAuth::where('user_id',$user->id)->first();
                $current_date = date('Y-m-d H:i:s');
                if($verify->expired_at!= null && $verify->expired_at < $current_date){
                    return response()->json([
                        'status' => false,
                        'message' => 'expired code',
                    ], 400);
                }
                else if($request->code != $verify->code){
                    return response()->json([
                        'status' => false,
                        'message' => 'invalid code',
                    ], 400);
                }
                DB::beginTransaction();
                $token = JWTAuth::fromUser($user);
                if($this->saveToken($user, $token)){
                    TwoFactorAuth::where('user_id',$user->id)->delete();
                    DB::commit();
                    return response()->json([
                        'status' => true,
                        'message' => 'token created successfully',
                        'token'=>JWTAuth::fromUser($user)
                    ], 200);
                }
                DB::rollBack();
            }
        }
        return response()->json([
            'status'=>false,
            'message'=>'invalid email or code'
        ], 500);
    }

    public function logout(){
        Auth::logout();
        $user = Auth::user();
        if($this->tokenRepository->isUserHasToken($user->id)){
            if($this->tokenRepository->deleteTokenByUserID($user->id)){
                return response()->json([
                    'status'=>true,
                    "message"=>"logged out successfully"
                ], 200);
            }
        }
        return response()->json([
            'status'=>false,
            "message"=>"unauthorized"
        ], 401);
    }

    public function forgetPassword($request){
        $validator =$this->validateForgetPassword($request);
        if($validator['status'] == false){
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator['errors']
            ], 422);
        }
        if($this->authRepository->existsByEmail($request->email)){
            $user = User::where('email', $request->email)->first();
            DB::beginTransaction();
            $deleteTokens = $this->tokenRepository->deleteTokenByUserID($user->id);
            if($this->sendResetCode($user->email) == true && $deleteTokens == true){
                DB::commit();
                return response()->json([
                    'status'=>true,
                    'message'=>'reset password code sent successfully check your inbox'
                ], 200);
            }
            DB::rollBack();
        }
        return response()->json([
            'status'=>false,
            'message'=>'failed to sent code'
        ], 500);
    }
    public function resetPassword($request){
        $validator =$this->validateResetPassword($request);
        if($validator['status'] == false){
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator['errors']
            ], 422);
        }
        if($this->authRepository->existsByEmail($request->email)){
            $user = User::where('email', $request->email)->first();
            if(!$this->resetPasswordRepository->isCodeExists($user->id, $request->code)){
                return response()->json([
                    'status'=>false,
                    'message'=>'invalid code'
                ], 500);
            }
            $date = date('Y-m-d H:i:s');
            $resetCode = $this->resetPasswordRepository->getByUserID($user->id);
            if($date > $resetCode->expires_at){
                return response()->json([
                    'status'=>false,
                    'message'=>'expired code'
                ], 500);
            }
            DB::beginTransaction();
            $deleteCode = $this->resetPasswordRepository->deleteCodeByUserID($user->id);
            $updatePassword = User::where('id', $user->id)->update([
                'password'=>Hash::make($request->password)
            ]);
            if($deleteCode && $updatePassword){
                DB::commit();
                return response()->json([
                    'status'=>true,
                    'message'=>'password changed successfully'
                ], 200);
            }
            DB::rollBack();
        }
        return response()->json([
            'status'=>false,
            'message'=>'invalid code'
        ], 500);
    }

    private function validateForgetPassword($request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|string|max:100',
        ]);
        return ValidatorClass::checkValidator($validator);
    }

    private function validateResetPassword($request){
        $messages = [
            'required' => 'The :attribute field is required.',
            'password'    => 'password must contain capital letters, small letters, numbers and special characters.',
        ];
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|string|max:100',
            'code' => 'required|string|max:6',
            'password' => [
                'required',
                'string',
                'min:8',             
                'regex:/[a-z]/',      
                'regex:/[A-Z]/',      
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ]
        ], $messages);
        return ValidatorClass::checkValidator($validator);
    }

    private function validateRegisterRequest($request){
        $messages = [
            'required' => 'The :attribute field is required.',
            'password'    => 'password must contain capital letters, small letters, numbers and special characters.',
        ];
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'email' => 'required|email|string|max:100',
            'password' => [
                'required',
                'string',
                'min:8',             
                'regex:/[a-z]/',      
                'regex:/[A-Z]/',      
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ]
        ],$messages);
        
        return ValidatorClass::checkValidator($validator);
    }

    private function validateLoginRequest($request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|string|max:100',
            'password' => [
                'required', 'string'
            ],
        ]);
        return ValidatorClass::checkValidator($validator);
    }

    private function validateVerifyEmailRequest($request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|string|max:100',
            'code' => [
                'required', 'string'
            ],
        ]);
        return ValidatorClass::checkValidator($validator);
    }

    private function validate2faLoginRequest($request){
        return $this->validateVerifyEmailRequest($request);
    }

    private function validateResendVerifyEmailRequest($request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|string|max:100',
        ]);
        return ValidatorClass::checkValidator($validator);
    }

    private function createUserWithRole($request){
        DB::beginTransaction();
        User::create([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'email'=>$request->email,
            'username'=>strtoupper($request->email),
            'password'=>Hash::make($request->password),
        ]);
        if($this->authRepository->existsByEmail($request->email)){
            $role = Roles::where('modified_role', 'USER')->first();
            $user = User::where('email', $request->email)->first();
            $addRoleToUser = $this->userRolesRepository->addToUser($user->id, $role->id);
            if($addRoleToUser){
                DB::commit();
                return true;
            }
            DB::rollBack();
            return false;
        }
        DB::rollBack();
        return false;
    }

    private function sendTwoFactorCode($email){
        $code = rand(100000,999999);
        $user = User::where('email', $email)->first();
        TwoFactorAuth::create([
            'code'=>$code,
            'user_id'=>$user->id,
            'expired_at'=>date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." +10 minutes"))
        ]);
        $isCodeCreated = TwoFactorAuth::where('user_id', $user->id)->exists();
        if($isCodeCreated){
            $sendMail = Mail::to($email)->send(new TwoFactorMail($code,  '('.$user->first_name.' '.$user->last_name.')'));
            return $sendMail != null;
        }
        return false;
    }
    private function sendResetCode($email){
        $code = rand(100000,999999);
        $user = User::where('email', $email)->first();
        if($this->resetPasswordRepository->isUserHasCode($user->id)){
            if(!$this->resetPasswordRepository->deleteCodeByUserID($user->id)){
                return false;
            }
        }
        $expirationDate = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." +10 minutes"));
        $saveCode = $this->resetPasswordRepository->saveCode($code, $user->id, $expirationDate);
        if($saveCode){
            $sendMail = Mail::to($email)->send(new ResetPasswordMail($code,  '('.$user->first_name.' '.$user->last_name.')'));
            return $sendMail != null;
        }
        return false;
    }

    private function sendEmailVerificationCode($email){
        $code = rand(100000,999999);
        $user = User::where('email', $email)->first();
        VerifyEmails::create([
            'code'=>$code,
            'user_id'=>$user->id,
            'expired_at'=>date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." +10 minutes"))
        ]);
        $isCodeCreated = VerifyEmails::where('user_id', $user->id)->exists();
        if($isCodeCreated){
            $sendMail = Mail::to($email)->send(new VerifyMail($code, '('.$user->first_name.' '.$user->last_name.')'));
            return $sendMail != null;
        }
        return false;
    }


    private function saveToken($user, $token){
        if($this->tokenRepository->isUserHasToken($user->id)){
            $this->tokenRepository->deleteTokenByUserID($user->id);
        }
        $date = date('Y-m-d H:i:s');
        $expirationDate = date('Y-m-d H:i:s', strtotime($date. ' + 1 days'));
        return $this->tokenRepository->saveToken($token, $user->id, $expirationDate);
    }

}
