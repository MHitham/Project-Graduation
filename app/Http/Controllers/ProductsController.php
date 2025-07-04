<?php

namespace App\Http\Controllers;

use App\Services\Product\IProductService;
use Exception;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    private IProductService $ProductService;
    public function __construct(IProductService $ProductService) {
        $this->ProductService = $ProductService;
    }
    public function add(Request $request){
        try{
            return $this->ProductService->add($request);
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
            return $this->ProductService->update($request);
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
            return $this->ProductService->delete($id);
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
            return $this->ProductService->get($id);
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
            return $this->ProductService->getAll();
        }
        catch(Exception $e){
                return response()->json([
                    'status'=>false,
                    'message'=>$e->getMessage()
                ], 500);  
        }
    }



}
