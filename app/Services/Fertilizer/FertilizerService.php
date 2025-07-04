<?php

namespace App\Services\Fertilizer;

use App\Classes\ValidatorClass;
use App\Repositories\Fertilizer\FertilizerRepository;
use App\Repositories\Fertilizer\IFertilizerRepository;
use Illuminate\Support\Facades\Validator;
use League\CommonMark\Parser\Block\BlockContinueParserWithInlinesInterface;

class FertilizerService implements IFertilizerService
{
    /**
     * Create a new class instance.
     */
    private IFertilizerRepository $_FertilizerRepository; 
    public function __construct(IFertilizerRepository $FertilizerRepository)
    {
        $this->_FertilizerRepository = $FertilizerRepository;
    }

    public function add($request){
        $validator =$this->_validateAddFertilizerRequest($request);
        if($validator['status'] == false){
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator['errors']
            ], 422);
        }
        $add = $this->_FertilizerRepository->add($request);
        if($add === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Fertilizer saved successfully'
            ], 201);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to Save Fertilizer'
        ], 500);
    }
    private function _validateAddFertilizerRequest($request){
        $validator = Validator::make($request->all(), [
            'name'=>['required','unique:fertilizers', 
            ],
            'description'=>['required']
        ]);
        return ValidatorClass::checkValidator($validator);
    }
    public function update($request){
        $validator =$this->_validateUpdateFertilizerRequest($request);
        if($validator['status'] == false){
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator['errors']
            ], 422);
        }
        $update = $this->_FertilizerRepository->updateByName($request);
        if($update === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Fertilizer updated successfully'
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to update Fertilizer'
        ], 500);
    }
    private function _validateUpdateFertilizerRequest($request){
        $validator = Validator::make($request->all(), [
            'old_name'=>['required', function($attribute, $value, $fail){
                $fertilizer = $this->_FertilizerRepository->getByNormalizedName($value);
                if($fertilizer===null){
                    $fail('fertilizer not found');
                }
            }],
            'name'=>['required','unique:fertilizers'],
            'description'=>['required']
        ]);
        return ValidatorClass::checkValidator($validator);
    }
    public function delete($request){
        $exists = $this->_FertilizerRepository->getByNormalizedName($request);
        if($exists === null){
            return response()->json([
                'status'=> false,
                'message'=> 'fertilizer not found'
            ], 404);
        }
        $delete = $this->_FertilizerRepository->deleteByName($request);
        if($delete === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Fertilizer deleted successfully'
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to delete Fertilizer'
        ], 500);
    }
    public function get($request){
        $exists = $this->_FertilizerRepository->getByNormalizedName($request);
        if($exists === null){
            return response()->json([
                'status'=> false,
                'message'=> 'fertilizer not found'
            ], 404);
        }
        $fertilizer = $this->_FertilizerRepository->getByNormalizedName($request);
        if($fertilizer === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Fertilizer found successfully',
                'model'=>$fertilizer
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to find Fertilizer'
        ], 500);
    }
    public function getAll(){
        $fertilizer = $this->_FertilizerRepository->getAll();
        return response()->json([
            'status'=> true,
            'message'=> 'Fertilizer found successfully',
            'model'=>$fertilizer
        ], 200);
    }
}
