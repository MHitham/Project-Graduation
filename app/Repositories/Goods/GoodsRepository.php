<?php

namespace App\Repositories\Goods;

use App\Models\Goods;

class GoodsRepository implements IGoodsRepository
{
    public function add($Good){
        try{
            Goods::create($Good);
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function existsById($id){
        return Goods::where("id", $id)->exists();
    }
    public function update($Goods){
        try{
            if($this->existsById($Goods->id)){
                Goods::where("id", $Goods->id)->update([
                    "name"=> $Goods->name,
                    "description"=> $Goods->description,
                    "price"=> $Goods->price,
                    "stock_quantity"=> $Goods->stock_quantity
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
            Goods::where("id", $id)->delete();
            return $this->existsById($id) === false;
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function getById($id){
        return Goods::where("id", $id)->first();
    }
    public function getAll(){
        return Goods::all();
    }
}
