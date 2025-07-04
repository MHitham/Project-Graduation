<?php

namespace App\Http\Controllers;

use App\Services\Cart\ICartService;
use Exception;
use Illuminate\Http\Request;

class CartController extends Controller
{
    
    private ICartService $CartService;
    public function __construct(ICartService $CartService) {
        $this->CartService = $CartService;
    }
    public function add(Request $request){
        try{
            return $this->CartService->add($request);
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
            return $this->CartService->update($request);
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
            return $this->CartService->delete($id);
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
            return $this->CartService->get($id);
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
            return $this->CartService->getAll();
        }
        catch(Exception $e){
                return response()->json([
                    'status'=>false,
                    'message'=>$e->getMessage()
                ], 500);  
        }
    }



}
