<?php

namespace App\Http\Controllers;

use App\Services\Category\ICategoryService;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private ICategoryService $categorySearvice;
    public function __construct(ICategoryService $categorySearvice) {
        $this->categorySearvice = $categorySearvice;
    }
    public function add(Request $request){
        try{
            return $this->categorySearvice->add($request);
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
            return $this->categorySearvice->update($request);
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
            return $this->categorySearvice->delete($name);
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
            return $this->categorySearvice->get($name);
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
            return $this->categorySearvice->getAll();
        }
        catch(Exception $e){
                return response()->json([
                    'status'=>false,
                    'message'=>$e->getMessage()
                ], 500);  
        }
    }
}
