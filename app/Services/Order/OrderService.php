<?php

namespace App\Services\Order;

use App\Classes\ValidatorClass;
use App\Repositories\Auth\IAuthRepository;
use App\Repositories\Order\IOrderRepository;
use Illuminate\Support\Facades\Validator;

class OrderService implements IOrderService
{
    /**
     * Create a new class instance.
     */
    private IOrderRepository $OrderRepository;
    private IAuthRepository $Auth;
    public function __construct(IAuthRepository $Auth, IOrderRepository $OrderRepository)
    {
        $this->OrderRepository = $OrderRepository;
        $this->Auth = $Auth;
    }
    private function _validateAdd($request){
        $validator = Validator::make($request->all(), [
            'user_id'=>['required', 'integer'],
            'order_date'=>['required', 'date'],
            'total_amount'=>['required', 'decimal'],
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
    private function _checkOrder($request){
        $exists = $this->OrderRepository->existsById($request);
        if($exists === false){
            return response()->json([
                'status'=> false,
                'message'=> 'Order not found'
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
        $add = $this->OrderRepository->add($request);
        if($add === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Order saved successfully'
            ], 201);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to Save Order'
        ], 500);
    }
    private function _validateUpdate($request){
        $validator = Validator::make($request->all(), [
            'user_id'=>['required', 'integer'],
            'order_date'=>['required', 'date'],
            'total_amount'=>['required', 'decimal'],
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
        if($this->_checkUser($request) !== true){
            return $this->_checkUser($request);
        }
        $update = $this->OrderRepository->update($request);
        if($update === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Order updated successfully'
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to update Order'
        ], 500);
    }
    public function delete($request){
        if($this->_checkOrder($request) !== true){
            return $this->_checkOrder($request);
        }
        $delete = $this->OrderRepository->deleteById($request);
        if($delete === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Order deleted successfully'
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to delete Order'
        ], 500);
    }
    public function get($request){
        if($this->_checkOrder($request) !== true){
            return $this->_checkOrder($request);
        }
        $Order = $this->OrderRepository->getById($request);
        if($Order !== null){
            return response()->json([
                'status'=> true,
                'message'=> 'Order found successfully',
                'model'=>$Order
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to find Order'
        ], 500);
    }
    public function getAll(){
        $Order = $this->OrderRepository->getAll();
        return response()->json([
            'status'=> true,
            'message'=> 'Order found successfully',
            'model'=>$Order
        ], 200);
    }

}
