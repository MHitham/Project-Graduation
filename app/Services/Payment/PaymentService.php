<?php

namespace App\Services\Payment;

use App\Classes\ValidatorClass;
use App\Repositories\Cart\ICartRepository;
use App\Repositories\Order\IOrderRepository;
use App\Repositories\Payment\IPaymentRepository;
use App\Repositories\PaymentMethod\IPaymentMethodRepository;
use App\Services\PaymentMethods\IPaymentMethodsService;
use Illuminate\Support\Facades\Validator;

class PaymentService
{
    /**
     * Create a new class instance.
     */
    private ICartRepository $CartRepository;
    private IOrderRepository $Order;
    private IPaymentMethodRepository $paymentMethodsRepository;
    private IPaymentRepository $paymentRepository;
    public function __construct(IOrderRepository $Order, ICartRepository $CartRepository,
    IPaymentMethodRepository $paymentMethodsRepository,IPaymentRepository $paymentRepository)
    {
        $this->CartRepository = $CartRepository;
        $this->Order = $Order;
        $this->paymentMethodsRepository = $paymentMethodsRepository;
        $this->paymentRepository = $paymentRepository;
    }
    private function _validateAdd($request){
        $validator = Validator::make($request->all(), [
            'cart_id'=>['required', 'integer'],
            'order_id'=>['required', 'integer'],
            'payment_method_id'=>['required', 'integer'],
            'payment_date'=>['required', 'date'],
            'price'=>['required', 'decimal'],
        ]);
        return ValidatorClass::checkValidator($validator);
    }
    private function _checkCartAndPaymentMethodAndOrder($request){
        $existsOrder = $this->Order->existsById($request->order_id);
        if($existsOrder === false){
            return response()->json([
                'status'=> false,
                'message'=> 'order not found'
            ], 404);
        }
        $existsPaymentMethod = $this->paymentMethodsRepository->existsById($request->payment_method_id);
        if($existsPaymentMethod === false){
            return response()->json([
                'status'=> false,
                'message'=> 'payment method not found'
            ], 404);
        }
        $existsCart = $this->CartRepository->existsById($request->cart_id);
        if($existsCart === false){
            return response()->json([
                'status'=> false,
                'message'=> 'cart not found'
            ], 404);
        }
        return true;
    }
    private function _checkPayment($request){
        $exists = $this->paymentRepository->existsById($request);
        if($exists === false){
            return response()->json([
                'status'=> false,
                'message'=> 'payment not found'
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
        if($this->_checkCartAndPaymentMethodAndOrder($request) !== true){
            return $this->_checkCartAndPaymentMethodAndOrder($request);
        }
        $add = $this->paymentRepository->add($request);
        if($add === true){
            return response()->json([
                'status'=> true,
                'message'=> 'payment saved successfully'
            ], 201);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to Save Cart'
        ], 500);
    }
    private function _validateUpdate($request){
        $validator = Validator::make($request->all(), [
            'cart_id'=>['required', 'integer'],
            'order_id'=>['required', 'integer'],
            'payment_method_id'=>['required', 'integer'],
            'payment_date'=>['required', 'date'],
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
        if($this->_checkPayment($request->id) !== true){
            return $this->_checkPayment($request->id);
        }
        if($this->_checkCartAndPaymentMethodAndOrder($request) !== true){
            return $this->_checkCartAndPaymentMethodAndOrder($request);
        }
        $update = $this->paymentRepository->update($request);
        if($update === true){
            return response()->json([
                'status'=> true,
                'message'=> 'payment updated successfully'
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to update Cart'
        ], 500);
    }
    public function delete($request){
        if($this->_checkPayment($request) !== true){
            return $this->_checkPayment($request);
        }
        $delete = $this->paymentRepository->deleteById($request);
        if($delete === true){
            return response()->json([
                'status'=> true,
                'message'=> 'Payment deleted successfully'
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to delete Payment'
        ], 500);
    }
    public function get($request){
        if($this->_checkPayment($request) !== true){
            return $this->_checkPayment($request);
        }
        $payment = $this->paymentRepository->getById($request);
        if($payment !== null){
            return response()->json([
                'status'=> true,
                'message'=> 'payment found successfully',
                'model'=>$payment
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to find payment'
        ], 500);
    }
    public function getAll(){
        $payments = $this->paymentRepository->getAll();
        return response()->json([
            'status'=> true,
            'message'=> 'payment found successfully',
            'model'=>$payments
        ], 200);
    }

}
