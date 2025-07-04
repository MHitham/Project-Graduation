<?php

namespace App\Services\Product;

use App\Classes\ValidatorClass;
use App\Repositories\Category\ICategoryRepository;
use App\Repositories\Product\IProductRepository;
use Illuminate\Support\Facades\Validator;

class ProductsService implements IProductService
{
/**
     * Create a new class instance.
     */
    private IProductRepository $ProductRepository;
    private ICategoryRepository $CategoryRepository;
    public function __construct(IProductRepository $ProductRepository,
    ICategoryRepository $CategoryRepository)
    {
        $this->ProductRepository = $ProductRepository;
        $this->CategoryRepository = $CategoryRepository;
    }
    private function _validateAdd($request){
        $validator = Validator::make($request->all(), [
            'category_id'=>['required', 'integer'],
            'name'=>['required', 'string'],
            'description'=>['required', 'string'],
            'price'=>['required', 'decimal'],
        ]);
        return ValidatorClass::checkValidator($validator);
    }
    private function _checkCategoty($request){
        $category_exists = $this->CategoryRepository->existsById($request->category_id);
        if(!$category_exists){
            return response()->json([
                'status'=> false,
                'message'=> 'Category not found'
            ], 404);
        }
    }
    private function _checkProduct($request){
        $product_exists = $this->ProductRepository->existsById($request);
        if(!$product_exists){
            return response()->json([
                'status'=> false,
                'message'=> 'Product not found'
            ], 404);
        }
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
        $this->_checkCategoty($request);
        $add = $this->ProductRepository->add($request);
        if($add === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Product saved successfully'
            ], 201);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to Save Product'
        ], 500);
    }
    private function _validateUpdate($request){
        $validator = Validator::make($request->all(), [
            'category_id'=>['required', 'integer'],
            'name'=>['required', 'string'],
            'description'=>['required', 'string'],
            'price'=>['required', 'decimal'],
            'id'=>['required', 'integer'],
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
        $this->_checkCategoty($request);
        $update = $this->ProductRepository->update($request);
        if($update === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Product updated successfully'
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to update Product'
        ], 500);
    }
    public function delete($request){
        $this->_checkProduct($request);
        $delete = $this->ProductRepository->deleteById($request->id);
        if($delete === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Product deleted successfully'
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to delete Product'
        ], 500);
    }
    public function get($request){
        $this->_checkProduct($request);
        $Product = $this->ProductRepository->getById($request->id);
        if($Product !== null){
            return response()->json([
                'status'=> true,
                'message'=> 'Product found successfully',
                'model'=>$Product
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to find Product'
        ], 500);
    }
    public function getAll(){
        $Product = $this->ProductRepository->getAll();
        return response()->json([
            'status'=> true,
            'message'=> 'Product found successfully',
            'model'=>$Product
        ], 200);
    }

}
