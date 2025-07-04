<?php

namespace App\Http\Controllers;

use App\Services\PaymentMethods\IPaymentMethodsService;
use Exception;
use Illuminate\Http\Request;

class PaymentMethodsController extends Controller
{
    private IPaymentMethodsService $PaymentMethodsSearvice;
    public function __construct(IPaymentMethodsService $PaymentMethodsSearvice) {
        $this->PaymentMethodsSearvice = $PaymentMethodsSearvice;
    }
    public function add(Request $request){
        try{
            return $this->PaymentMethodsSearvice->add($request);
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
            return $this->PaymentMethodsSearvice->update($request);
        }
        catch(Exception $e){
                return response()->json([
                    'status'=>false,
                    'message'=>$e->getMessage()
                ], 500);  
        }
    }

    public function delete($name){
        try{
            return $this->PaymentMethodsSearvice->delete($name);
        }
        catch(Exception $e){
                return response()->json([
                    'status'=>false,
                    'message'=>$e->getMessage()
                ], 500);  
        }
    }

    public function get($name){
        try{
            return $this->PaymentMethodsSearvice->get($name);
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
            return $this->PaymentMethodsSearvice->getAll();
        }
        catch(Exception $e){
                return response()->json([
                    'status'=>false,
                    'message'=>$e->getMessage()
                ], 500);  
        }
    }


}
