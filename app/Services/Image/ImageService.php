<?php

namespace App\Services\Image;

use App\Classes\ValidatorClass;
use App\Repositories\Images\IImageReposiroty;
use Illuminate\Support\Facades\Validator;

class ImageService implements IImageService
{
/**
     * Create a new class instance.
     */
    private IImageReposiroty $imageRepository;
    public function __construct(IImageReposiroty $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }
    private function _validateAdd($request){
        $validator = Validator::make($request->all(), [
            'url'=>['required','unique:images', 
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
        $add = $this->imageRepository->add($request);
        if($add === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Image saved successfully'
            ], 201);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to Save Image'
        ], 500);
    }
    public function delete($request){
        $exists = $this->imageRepository->getById($request);
        if($exists === null){
            return response()->json([
                'status'=> false,
                'message'=> 'Image not found'
            ], 404);
        }
        $delete = $this->imageRepository->deleteById($request);
        if($delete === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Image deleted successfully'
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to delete Image'
        ], 500);
    }
    public function get($request){
        $exists = $this->imageRepository->getById($request);
        if($exists === null){
            return response()->json([
                'status'=> false,
                'message'=> 'Image not found'
            ], 404);
        }
        $Image = $this->imageRepository->getById($request);
        if($Image !== null){
            return response()->json([
                'status'=> true,
                'message'=> 'Image found successfully',
                'model'=>$Image
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to find Image'
        ], 500);
    }
    public function getAll(){
        $Image = $this->imageRepository->getAll();
        return response()->json([
            'status'=> true,
            'message'=> 'Image found successfully',
            'model'=>$Image
        ], 200);
    }

    private function _validateUpdate($request){
        $validator = Validator::make($request->all(), [
            'id'=>['required'],
            'url'=>['required','unique:Categorys']
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
        $update = $this->imageRepository->update($request);
        if($update === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Image updated successfully'
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to update Image'
        ], 500);
    }

}
