<?php

namespace App\Repositories\PaymentMethod;

use App\Models\PaymentMethod;

class PaymentMethodRepository implements IPaymentMethodRepository
{
    public function add($PaymentMethod){
        try{

            PaymentMethod::create([
                "name"=> $PaymentMethod->name,
                "normalized_name"=>strtoupper($PaymentMethod->name)
            ]);
            return $this->isPaymentMethodExistsByName($PaymentMethod->name);
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function getByNormalizedName($name){
        return PaymentMethod::where("normalized_name", strtoupper($name))->first();
    }
    public function isExistsByName($name){
        return PaymentMethod::where("normalized_name", strtoupper($name))->exists();
    }
    public function updateByName($season){
        try{
            PaymentMethod::where("normalized_name", strtoupper($season->old_name))->update([
                "name"=> $season->name,
            ]);
            return $this->isExistsByName($season->name);
            
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function deleteByName($name){
        try{
            PaymentMethod::where("normalized_name", strtoupper($name))->delete();
            return $this->isExistsByName($name) === false;
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function existsById($id){
        return PaymentMethod::where("id", $id)->exists();
    }
    public function isPaymentMethodExistsByName($name){
        return PaymentMethod::where("normalized_name", strtoupper($name))->exists();
    }
    public function update($PaymentMethod){
        try{
            if($this->existsById($PaymentMethod->id)){
                PaymentMethod::where("id", $PaymentMethod->id)->update([
                    "name"=> $PaymentMethod->name,
                    "normalized_name"=> strtoupper($PaymentMethod->name)
                ]);
                return $this->isPaymentMethodExistsByName($PaymentMethod->name);
            }
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
        return false;
    }
    public function deleteById($id){
        try{
            PaymentMethod::where("id", $id)->delete();
            return $this->existsById($id) === false;
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function getById($id){
        return PaymentMethod::where("id", $id)->first();
    }
    public function getAll(){
        return PaymentMethod::all();
    }
}
