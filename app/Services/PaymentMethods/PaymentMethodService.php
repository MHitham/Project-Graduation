<?php

namespace App\Services\PaymentMethods;

use App\Classes\ValidatorClass;
use App\Repositories\PaymentMethod\IPaymentMethodRepository;
use Illuminate\Support\Facades\Validator;

class PaymentMethodService implements IPaymentMethodsService
{
/**
     * Create a new class instance.
     */
    private IPaymentMethodRepository $paymentMethodRepository;
    public function __construct(IpaymentMethodRepository $paymentMethodRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }
    private function _validateAdd($request){
        $validator = Validator::make($request->all(), [
            'name'=>['required','unique:payment_methods', 
            ],
            
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
        $add = $this->paymentMethodRepository->add($request);
        if($add === true){
            return response()->json([
                'status'=> true,
                'message'=> 'paymentMethod saved successfully'
            ], 201);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to Save paymentMethod'
        ], 500);
    }
    private function _validateUpdate($request){
        $validator = Validator::make($request->all(), [
            'old_name'=>['required', function($attribute, $value, $fail){
                $paymentMethod = $this->paymentMethodRepository->getByNormalizedName($value);
                if($paymentMethod===null){
                    $fail('paymentMethod not found');
                }
            }],
            'name'=>['required','unique:payment_methods'],
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
        $update = $this->paymentMethodRepository->updateByName($request);
        if($update === true){
            return response()->json([
                'status'=> true,
                'message'=> 'paymentMethod updated successfully'
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to update paymentMethod'
        ], 500);
    }
    public function delete($request){
        $exists = $this->paymentMethodRepository->getByNormalizedName($request);
        if($exists === null){
            return response()->json([
                'status'=> false,
                'message'=> 'paymentMethod not found'
            ], 404);
        }
        $delete = $this->paymentMethodRepository->deleteByName($request);
        if($delete === true){
            return response()->json([
                'status'=> true,
                'message'=> 'paymentMethod deleted successfully'
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to delete paymentMethod'
        ], 500);
    }
    public function get($request){
        $exists = $this->paymentMethodRepository->getByNormalizedName($request);
        if($exists === null){
            return response()->json([
                'status'=> false,
                'message'=> 'paymentMethod not found'
            ], 404);
        }
        $paymentMethod = $this->paymentMethodRepository->getByNormalizedName($request);
        if($paymentMethod !== null){
            return response()->json([
                'status'=> true,
                'message'=> 'paymentMethod found successfully',
                'model'=>$paymentMethod
            ], 200);
        }
        return response()->json([
            'status'=> false,
            'message'=> 'Failed to find paymentMethod'
        ], 500);
    }
    public function getAll(){
        $paymentMethod = $this->paymentMethodRepository->getAll();
        return response()->json([
            'status'=> true,
            'message'=> 'paymentMethod found successfully',
            'model'=>$paymentMethod
        ], 200);
    }

}
