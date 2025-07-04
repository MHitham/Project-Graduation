<?php

namespace App\Http\Controllers;

use App\Services\Disease\IDiseaseService;
use Exception;
use Illuminate\Http\Request;

class DiseaseController extends Controller
{
    private IDiseaseService $diseaseSearvice;
    public function __construct(IDiseaseService $diseaseSearvice) {
        $this->diseaseSearvice = $diseaseSearvice;
    }
    public function add(Request $request){
        try{
            return $this->diseaseSearvice->add($request);
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
            return $this->diseaseSearvice->update($request);
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
            return $this->diseaseSearvice->delete($name);
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
            return $this->diseaseSearvice->get($name);
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
            return $this->diseaseSearvice->getAll();
        }
        catch(Exception $e){
                return response()->json([
                    'status'=>false,
                    'message'=>$e->getMessage()
                ], 500);  
        }
    }

}
