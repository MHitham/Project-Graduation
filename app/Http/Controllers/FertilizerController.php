<?php

namespace App\Http\Controllers;

use App\Services\Fertilizer\IFertilizerService;
use Exception;
use Illuminate\Http\Request;

class FertilizerController extends Controller
{
    private IFertilizerService $fiertilizerService;
    public function __construct(IFertilizerService $fiertilizerService) {
        $this->fiertilizerService = $fiertilizerService;
    }
    public function add(Request $request){
        try{
            return $this->fiertilizerService->add($request);
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
            return $this->fiertilizerService->update($request);
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
            return $this->fiertilizerService->delete($name);
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
            return $this->fiertilizerService->get($name);
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
            return $this->fiertilizerService->getAll();
        }
        catch(Exception $e){
                return response()->json([
                    'status'=>false,
                    'message'=>$e->getMessage()
                ], 500);  
        }
    }

}
