<?php

namespace App\Services\Disease;

use App\Classes\ValidatorClass;
use App\Repositories\Disease\IDiseaseRepository;
use Illuminate\Support\Facades\Validator;

class DiseaseService implements IDiseaseService
{
    /**
     * Create a new class instance.
     */
    private IDiseaseRepository $diseaseRepository;
    public function __construct(IDiseaseRepository $diseaseRepository)
    {
        $this->diseaseRepository = $diseaseRepository;
    }
    private function _validateAdd($request){
        $validator = Validator::make($request->all(), [
            'name'=>['required','unique:diseases', 
            ],
            'description'=>['required'],
            'treatment'=>['required', 
            ]
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
        $add = $this->diseaseRepository->add($request);
        if($add === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Disease saved successfully'
            ], 201);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to Save Disease'
        ], 500);
    }
    private function _validateUpdate($request){
        $validator = Validator::make($request->all(), [
            'old_name'=>['required', function($attribute, $value, $fail){
                $disease = $this->diseaseRepository->getByNormalizedName($value);
                if($disease===null){
                    $fail('disease not found');
                }
            }],
            'name'=>['required','unique:diseases'],
            'description'=>['required'],
            'treatment'=>['required'],
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
        $update = $this->diseaseRepository->updateByName($request);
        if($update === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Disease updated successfully'
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to update Disease'
        ], 500);
    }
    public function delete($request){
        $exists = $this->diseaseRepository->getByNormalizedName($request);
        if($exists === null){
            return response()->json([
                'status'=> false,
                'message'=> 'disease not found'
            ], 404);
        }
        $delete = $this->diseaseRepository->deleteByName($request);
        if($delete === true){
            return response()->json([
                'status'=> true,
                'message'=> 'disease deleted successfully'
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to delete disease'
        ], 500);
    }
    public function get($request){
        $exists = $this->diseaseRepository->getByNormalizedName($request);
        if($exists === null){
            return response()->json([
                'status'=> false,
                'message'=> 'disease not found'
            ], 404);
        }
        $disease = $this->diseaseRepository->getByNormalizedName($request);
        if($disease !== null){
            return response()->json([
                'status'=> true,
                'message'=> 'Disease found successfully',
                'model'=>$disease
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to find disease'
        ], 500);
    }
    public function getAll(){
        $disease = $this->diseaseRepository->getAll();
        return response()->json([
            'status'=> true,
            'message'=> 'disease found successfully',
            'model'=>$disease
        ], 200);
    }
}
