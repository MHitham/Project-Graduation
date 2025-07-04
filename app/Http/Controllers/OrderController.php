<?php

namespace App\Http\Controllers;

use App\Services\Order\IOrderService;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    
    private IOrderService $OrderService;
    public function __construct(IOrderService $OrderService) {
        $this->OrderService = $OrderService;
    }
    public function add(Request $request){
        try{
            return $this->OrderService->add($request);
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
            return $this->OrderService->update($request);
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
            return $this->OrderService->delete($id);
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
            return $this->OrderService->get($id);
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
            return $this->OrderService->getAll();
        }
        catch(Exception $e){
                return response()->json([
                    'status'=>false,
                    'message'=>$e->getMessage()
                ], 500);  
        }
    }


}
