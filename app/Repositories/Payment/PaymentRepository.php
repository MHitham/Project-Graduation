<?php

namespace App\Repositories\Payment;

use App\Models\Payment;

class PaymentRepository implements IPaymentRepository
{
    public function add($Payment){
        try{

            Payment::create($Payment);
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function existsById($id){
        return Payment::where("id", $id)->exists();
    }
    public function update($Payment){
        try{
            if($this->existsById($Payment->id)){
                Payment::where("id", $Payment->id)->update([
                    "cart_id"=> $Payment->cart_id,
                    "order_id"=> $Payment->order_id,
                    "payment_date"=> $Payment->payment_date,
                    "price"=> $Payment->price,
                    "payment_method_id"=> $Payment->payment_method_id,
                ]);
            }
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
        return false;
    }
    public function deleteById($id){
        try{
            Payment::where("id", $id)->delete();
            return $this->existsById($id) === false;
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function getById($id){
        return Payment::where("id", $id)->first();
    }
    public function getAll(){
        return Payment::all();
    }
}
