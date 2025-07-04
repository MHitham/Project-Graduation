<?php

namespace App\Http\Controllers;

use App\Services\Soil\ISoilService;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;

class SoilController extends Controller
{
    private ISoilService $soilService;
    public function __construct(ISoilService $soilSearvice) {
        $this->soilService = $soilSearvice;
    }
    public function add(Request $request){
        try{
            // $user = User::where(['id'=>auth()->id()])->get()->first();
            // if($user!=null){
            //     return $this->soilService->add($request);        
            // }
            // return response()->json([
            //     'status'=>false,
            //     'message'=>'unauthorized'
            // ], 401); 
            return $this->soilService->add($request);    
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
            return $this->soilService->update($request);
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
            return $this->soilService->delete($name);
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
            return $this->soilService->get($name);
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
            return $this->soilService->getAll();
        }
        catch(Exception $e){
                return response()->json([
                    'status'=>false,
                    'message'=>$e->getMessage()
                ], 500);  
        }
    }
}
