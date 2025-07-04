<?php

namespace App\Services\Soil;

use App\Classes\ValidatorClass;
use App\Repositories\Soil\ISoilRepository;
use Illuminate\Support\Facades\Validator;

class SoilService implements ISoilService
{
/**
     * Create a new class instance.
     */
    private ISoilRepository $soilRepository;
    public function __construct(ISoilRepository $soilRepository)
    {
        $this->soilRepository = $soilRepository;
    }
    private function _validateAdd($request){
        $validator = Validator::make($request->all(), [
            'name'=>['required','unique:soils'],
        ]);
        return ValidatorClass::checkValidator($validator);
    }
    public function add($request){
        $validator =$this->_validateAdd($request);
        if($validator['status'] == false){
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator['errors']
            ], 422);
        }
        $add = $this->soilRepository->add($request);
        if($add === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Soil saved successfully'
            ], 201);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to Save Soil'
        ], 500);
    }
    private function _validateUpdate($request){
        $validator = Validator::make($request->all(), [
            'old_name'=>['required', function($attribute, $value, $fail){
                $Soil = $this->soilRepository->getByNormalizedName($value);
                if($Soil===null){
                    $fail('Soil not found');
                }
            }],
            'name'=>['required','unique:Soils'],
        ]);
        return ValidatorClass::checkValidator($validator);
    }
    public function update($request){
        $validator =$this->_validateUpdate($request);
        if($validator['status'] == false){
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator['errors']
            ], 422);
        }
        $update = $this->soilRepository->updateByName($request);
        if($update === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Soil updated successfully'
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to update Soil'
        ], 500);
    }
    public function delete($request){
        $exists = $this->soilRepository->getByNormalizedName($request);
        if($exists === null){
            return response()->json([
                'status'=> false,
                'message'=> 'Soil not found'
            ], 404);
        }
        $delete = $this->soilRepository->deleteByName($request);
        if($delete === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Soil deleted successfully'
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to delete Soil'
        ], 500);
    }
    public function get($request){
        $exists = $this->soilRepository->getByNormalizedName($request);
        if($exists === null){
            return response()->json([
                'status'=> false,
                'message'=> 'Soil not found'
            ], 404);
        }
        $Soil = $this->soilRepository->getByNormalizedName($request);
        if($Soil !== null){
            return response()->json([
                'status'=> true,
                'message'=> 'Soil found successfully',
                'model'=>$Soil
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to find Soil'
        ], 500);
    }
    public function getAll(){
        $Soil = $this->soilRepository->getAll();
        return response()->json([
            'status'=> true,
            'message'=> 'Soil found successfully',
            'model'=>$Soil
        ], 200);
    }
}
