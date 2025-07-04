<?php

namespace App\Http\Controllers;

use App\Services\Season\ISeasonService;
use Exception;
use Illuminate\Http\Request;

class SeasonsController extends Controller
{
    private ISeasonService $SeasonService;
    public function __construct(ISeasonService $SeasonService) {
        $this->SeasonService = $SeasonService;
    }
    public function add(Request $request){
        try{
            return $this->SeasonService->add($request);
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
            return $this->SeasonService->update($request);
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
            return $this->SeasonService->delete($name);
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
            return $this->SeasonService->get($name);
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
            return $this->SeasonService->getAll();
        }
        catch(Exception $e){
                return response()->json([
                    'status'=>false,
                    'message'=>$e->getMessage()
                ], 500);  
        }
    }


}
