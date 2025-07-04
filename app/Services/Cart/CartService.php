<?php

namespace App\Services\Cart;

use App\Classes\ValidatorClass;
use App\Models\User;
use App\Repositories\Auth\IAuthRepository;
use App\Repositories\Cart\ICartRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartService implements ICartService
{
    /**
     * Create a new class instance.
     */
    private ICartRepository $CartRepository;
    private IAuthRepository $Auth;
    public function __construct(IAuthRepository $Auth, ICartRepository $CartRepository)
    {
        $this->CartRepository = $CartRepository;
        $this->Auth = $Auth;
    }
    private function _validateAdd($request){
        $validator = Validator::make($request->all(), [
            'user_id'=>['required', 'integer'],
            'card_number'=>['required', 'string'],
            'expiry_date'=>['required', 'string'],
        ]);
        return ValidatorClass::checkValidator($validator);
    }
    private function _checkUser($request){
        $exists = $this->Auth->existsById($request->user_id);
        if($exists === false){
            return response()->json([
                'status'=> false,
                'message'=> 'user not found'
            ], 404);
        }
        return true;
    }
    private function _checkCart($request){
        $exists = $this->CartRepository->existsById($request);
        if($exists === false){
            return response()->json([
                'status'=> false,
                'message'=> 'cart not found'
            ], 404);
        }
        return true;
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
        if($this->_checkUser($request) !== true){
            return $this->_checkUser($request);
        }
        $add = $this->CartRepository->add($request);
        if($add === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Cart saved successfully'
            ], 201);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to Save Cart'
        ], 500);
    }
    private function _validateUpdate($request){
        $validator = Validator::make($request->all(), [
            'user_id'=>['required', 'integer'],
            'card_number'=>['required', 'string'],
            'expiry_date'=>['required', 'date'],
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
        $this->_checkUser($request);
        $update = $this->CartRepository->update($request);
        if($update === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Cart updated successfully'
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to update Cart'
        ], 500);
    }
    public function delete($request){
        $this->_checkCart($request);
        $delete = $this->CartRepository->deleteById($request);
        if($delete === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Cart deleted successfully'
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to delete Cart'
        ], 500);
    }
    public function get($request){
        if($this->_checkCart($request) !== true){
            return $this->_checkCart($request);
        }
        $Cart = $this->CartRepository->getById($request);
        if($Cart !== null){
            return response()->json([
                'status'=> true,
                'message'=> 'Cart found successfully',
                'model'=>$Cart
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to find Cart'
        ], 500);
    }
    public function getAll(){
        $Cart = $this->CartRepository->getAll();
        return response()->json([
            'status'=> true,
            'message'=> 'Cart found successfully',
            'model'=>$Cart
        ], 200);
    }

}
