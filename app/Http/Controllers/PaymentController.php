<?php

namespace App\Http\Controllers;

use App\Services\Payment\IPaymentService;
use Exception;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    
    private IPaymentService $PaymentService;
    public function __construct(IPaymentService $PaymentService) {
        $this->PaymentService = $PaymentService;
    }
    public function add(Request $request){
        try{
            return $this->PaymentService->add($request);
        }
        catch(Exception $e){
                return response()->json([
                    'status'=>false,
                    'message'=>$e->getMessage()
                ], 500);  
        }
    }

    public function update(Request $request){
        try{
            return $this->PaymentService->update($request);
        }
        catch(Exception $e){
                return response()->json([
                    'status'=>false,
                    'message'=>$e->getMessage()
                ], 500);  
        }
    }

    public function delete($id){
        try{
            return $this->PaymentService->delete($id);
        }
        catch(Exception $e){
                return response()->json([
                    'status'=>false,
                    'message'=>$e->getMessage()
                ], 500);  
        }
    }

    public function get($id){
        try{
            return $this->PaymentService->get($id);
        }
        catch(Exception $e){
                return response()->json([
                    'status'=>false,
                    'message'=>$e->getMessage()
                ], 500);  
        }
    }

    public function getAll(){
        try{
            return $this->PaymentService->getAll();
        }
        catch(Exception $e){
                return response()->json([
                    'status'=>false,
                    'message'=>$e->getMessage()
                ], 500);  
        }
    }


}
