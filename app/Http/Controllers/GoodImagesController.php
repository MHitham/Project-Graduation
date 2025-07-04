<?php

namespace App\Http\Controllers;

use App\Services\GoodImages\IGoodImagesService;
use Exception;
use Illuminate\Http\Request;

class GoodImagesController extends Controller
{
    private IGoodImagesService $GoodImagesService;
    public function __construct(IGoodImagesService $GoodImagesService) {
        $this->GoodImagesService = $GoodImagesService;
    }
    public function add(Request $request){
        try{
            return $this->GoodImagesService->add($request);
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
            return $this->GoodImagesService->update($request);
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
            return $this->GoodImagesService->delete($id);
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
            return $this->GoodImagesService->get($id);
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
            return $this->GoodImagesService->getAll();
        }
        catch(Exception $e){
                return response()->json([
                    'status'=>false,
                    'message'=>$e->getMessage()
                ], 500);  
        }
    }


}
