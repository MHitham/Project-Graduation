<?php

namespace App\Services\Season;

use App\Classes\ValidatorClass;
use App\Repositories\Season\ISeasonRepository;
use Illuminate\Support\Facades\Validator;

class SeasonService implements ISeasonService
{
/**
     * Create a new class instance.
     */
    private ISeasonRepository $_SeasonRepository; 
    public function __construct(ISeasonRepository $SeasonRepository)
    {
        $this->_SeasonRepository = $SeasonRepository;
    }

    public function add($request){
        $validator =$this->_validateAddSeasonRequest($request);
        if($validator['status'] == false){
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator['errors']
            ], 422);
        }
        $add = $this->_SeasonRepository->add($request);
        if($add === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Season saved successfully'
            ], 201);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to Save Season'
        ], 500);
    }
    private function _validateAddSeasonRequest($request){
        $validator = Validator::make($request->all(), [
            'name'=>['required','unique:Seasons', ],
        ]);
        return ValidatorClass::checkValidator($validator);
    }
    public function update($request){
        $validator =$this->_validateUpdateSeasonRequest($request);
        if($validator['status'] == false){
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator['errors']
            ], 422);
        }
        $update = $this->_SeasonRepository->updateByName($request);
        if($update === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Season updated successfully'
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to update Season'
        ], 500);
    }
    private function _validateUpdateSeasonRequest($request){
        $validator = Validator::make($request->all(), [
            'old_name'=>['required', function($attribute, $value, $fail){
                $Season = $this->_SeasonRepository->getByNormalizedName($value);
                if($Season===null){
                    $fail('Season not found');
                }
            }],
            'name'=>['required','unique:Seasons'],
        ]);
        return ValidatorClass::checkValidator($validator);
    }
    public function delete($request){
        $exists = $this->_SeasonRepository->getByNormalizedName($request);
        if($exists === null){
            return response()->json([
                'status'=> false,
                'message'=> 'Season not found'
            ], 404);
        }
        $delete = $this->_SeasonRepository->deleteByName($request);
        if($delete === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Season deleted successfully'
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to delete Season'
        ], 500);
    }
    public function get($request){
        $exists = $this->_SeasonRepository->getByNormalizedName($request);
        if($exists === null){
            return response()->json([
                'status'=> false,
                'message'=> 'Season not found'
            ], 404);
        }
        $Season = $this->_SeasonRepository->getByNormalizedName($request);
        if($Season === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Season found successfully',
                'model'=>$Season
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to find Season'
        ], 500);
    }
    public function getAll(){
        $Season = $this->_SeasonRepository->getAll();
        return response()->json([
            'status'=> true,
            'message'=> 'Season found successfully',
            'model'=>$Season
        ], 200);
    }

}
