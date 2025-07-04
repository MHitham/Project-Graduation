<?php

namespace App\Services\Category;

use App\Classes\ValidatorClass;
use App\Repositories\Category\ICategoryRepository;
use Illuminate\Support\Facades\Validator;

class CategoryService implements ICategoryService
{
/**
     * Create a new class instance.
     */
    private ICategoryRepository $CategoryRepository;
    public function __construct(ICategoryRepository $CategoryRepository)
    {
        $this->CategoryRepository = $CategoryRepository;
    }
    private function _validateAdd($request){
        $validator = Validator::make($request->all(), [
            'name'=>['required','unique:categories', 
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
        $add = $this->CategoryRepository->add($request);
        if($add === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Category saved successfully'
            ], 201);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to Save Category'
        ], 500);
    }
    private function _validateUpdate($request){
        $validator = Validator::make($request->all(), [
            'old_name'=>['required', function($attribute, $value, $fail){
                $Category = $this->CategoryRepository->getByNormalizedName($value);
                if($Category===null){
                    $fail('Category not found');
                }
            }],
            'name'=>['required','unique:Categorys'],
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
        $update = $this->CategoryRepository->updateByName($request);
        if($update === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Category updated successfully'
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to update Category'
        ], 500);
    }
    public function delete($request){
        $exists = $this->CategoryRepository->getByNormalizedName($request);
        if($exists === null){
            return response()->json([
                'status'=> false,
                'message'=> 'Category not found'
            ], 404);
        }
        $delete = $this->CategoryRepository->deleteByName($request);
        if($delete === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Category deleted successfully'
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to delete Category'
        ], 500);
    }
    public function get($request){
        $exists = $this->CategoryRepository->getByNormalizedName($request);
        if($exists === null){
            return response()->json([
                'status'=> false,
                'message'=> 'Category not found'
            ], 404);
        }
        $Category = $this->CategoryRepository->getByNormalizedName($request);
        if($Category !== null){
            return response()->json([
                'status'=> true,
                'message'=> 'Category found successfully',
                'model'=>$Category
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to find Category'
        ], 500);
    }
    public function getAll(){
        $Category = $this->CategoryRepository->getAll();
        return response()->json([
            'status'=> true,
            'message'=> 'Category found successfully',
            'model'=>$Category
        ], 200);
    }

}
