<?php

namespace App\Http\Controllers\IdentityMiddleware;

use App\Http\Controllers\Controller;

use App\Services\Auth\IAuthService;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private IAuthService $_authService;
    public function __construct(IAuthService $authService){
        $this->_authService = $authService;
    }

/**
 * @SWG\POST(
 *     path="/auth/register",
 *     summary="register",
 *     tags={"register"},
 *     @SWG\Response(response=200, description="Successful operation"),
 *     @SWG\Response(response=400, description="Invalid request")
 *     @SWG\Response(response=500, description="Internal server error")
 * )
*/

    public function register(Request $request){
        try{
            return $this->_authService->register($request);
        }
        catch(Exception $e){
                return response()->json([
                    'status'=>false,
                    'message'=>$e->getMessage()
                ], 500);  
        }
    }

    public function verifyEmail(Request $request){
        try{
            return $this->_authService->verifyEmail($request);
        }
        catch(Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ], 500);  
        }
    }
    public function resendEmailVerificationCode(Request $request){
        try{
            return $this->_authService->resendEmailVerificationCode($request);
        }
        catch(Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ], 500);  
        }
    }

    public function login(Request $request){
        try{
            return $this->_authService->login($request);
        }
        catch(Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ], 500);  
        }
    }
    public function login2fa(Request $request){
        try{
            return $this->_authService->login2fa($request);
        }
        catch(Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ], 500);  
        }
    }

    public function logout(){
        try{
            return $this->_authService->logout();
        }
        catch(Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ], 500);  
        }
    }
    public function forgetPassword(Request $request){
        try{
            return $this->_authService->forgetPassword($request);
        }
        catch(Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ], 500);  
        }
    }
    public function resetPassword(Request $request){
        try{
            return $this->_authService->resetPassword($request);
        }
        catch(Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ], 500);  
        }
    }

}
