<?php

namespace App\Repositories\Order;

use App\Models\Order;

class OrderRepository implements IOrderRepository
{
    public function add($Order){
        try{

            Order::create($Order);
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function existsById($id){
        return Order::where("id", $id)->exists();
    }
    public function update($Order){
        try{
            if($this->existsById($Order->id)){
                Order::where("id", $Order->id)->update([
                    "total_amount"=> $Order->total_amount,
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
            Order::where("id", $id)->delete();
            return $this->existsById($id) === false;
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function getById($id){
        return Order::where("id", $id)->first();
    }
    public function getAll(){
        return Order::all();
    }
}
