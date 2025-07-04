<?php

namespace App\Repositories\Cart;

use App\Models\Cart;

class CartRepository implements ICartRepository
{
    public function add($cart){
        try{

            Cart::create($cart);
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function existsById($id){
        return Cart::where("id", $id)->exists();
    }
    public function update($Cart){
        try{
            if($this->existsById($Cart->id)){
                Cart::where("id", $Cart->id)->update([
                    "card_number"=> $Cart->card_number,
                    "expiry_date"=> $Cart->expiry_date,
                    "cvv"=> $Cart->cvv,
                ]);
                return true;
            }
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
        return false;
    }
    public function deleteById($id){
        try{
            Cart::where("id", $id)->delete();
            return $this->existsById($id) === false;
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function getById($id){
        return Cart::where("id", $id)->first();
    }
    public function getAll(){
        return Cart::all();
    }
}
