<?php

namespace App\Services\GoodImages;

use App\Classes\ValidatorClass;
use App\Repositories\GoodImages\IGoodImageRepository;
use App\Repositories\Goods\IGoodsRepository;
use App\Repositories\Images\IImageReposiroty;
use Illuminate\Support\Facades\Validator;

class GoodImagesService implements IGoodImagesService
{
/**
     * Create a new class instance.
     */
    private IGoodImageRepository $GoodImageRepository;
    private IGoodsRepository $goodsRepository;
    private IImageReposiroty $imageReposiroty;
    public function __construct(IGoodImageRepository $GoodImageRepository,
    IGoodsRepository $goodsRepository, IImageReposiroty $imageReposiroty)
    {
        $this->GoodImageRepository = $GoodImageRepository;
        $this->goodsRepository = $goodsRepository;
        $this->imageReposiroty = $imageReposiroty;
    }
    private function _validateAdd($request){
        $validator = Validator::make($request->all(), [
            'good_id'=>['required'],
            'image_id'=>['required']
        ]);
        return ValidatorClass::checkValidator($validator);
    }
    private function _checkImageAndGood($request){
        $image_exists = $this->imageReposiroty->existsById($request->image_id);
        if(!$image_exists){
            return response()->json([
                'status'=> false,
                'message'=> 'Image not found'
            ], 404);
        }
        $good_exists = $this->goodsRepository->existsById($request->good_id);
        if(!$good_exists){
            return response()->json([
                'status'=> false,
                'message'=> 'Good not found'
            ], 404);
        }
    }
    private function _checkGoodImage($request){
        $goodImage = $this->GoodImageRepository->existsById($request->id);
        if(!$goodImage){
            return response()->json([
                'status'=> false,
                'message'=> 'Good Image not found'
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
        $this->_checkImageAndGood($request);
        $add = $this->GoodImageRepository->add($request);
        if($add === true){
            return response()->json([
                'status'=> true,
                'message'=> 'GoodImage saved successfully'
            ], 201);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to Save GoodImage'
        ], 500);
    }
    private function _validateUpdate($request){
        $validator = Validator::make($request->all(), [
            'good_id'=>['required'],
            'image_id'=>['required'],
            'id'=>['required']
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
        $this->_checkGoodImage($request);
        $this->_checkImageAndGood($request);
        $update = $this->GoodImageRepository->update($request);
        if($update === true){
            return response()->json([
                'status'=> true,
                'message'=> 'GoodImage updated successfully'
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to update GoodImage'
        ], 500);
    }
    public function delete($request){
        $this->_checkGoodImage($request);
        $delete = $this->GoodImageRepository->deleteById($request->id);
        if($delete === true){
            return response()->json([
                'status'=> true,
                'message'=> 'GoodImage deleted successfully'
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to delete GoodImage'
        ], 500);
    }
    public function get($request){
        $this->_checkGoodImage($request);
        $GoodImage = $this->GoodImageRepository->getById($request->id);
        if($GoodImage !== null){
            return response()->json([
                'status'=> true,
                'message'=> 'GoodImage found successfully',
                'model'=>$GoodImage
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to find GoodImage'
        ], 500);
    }
    public function getAll(){
        $GoodImage = $this->GoodImageRepository->getAll();
        return response()->json([
            'status'=> true,
            'message'=> 'GoodImage found successfully',
            'model'=>$GoodImage
        ], 200);
    }

}
