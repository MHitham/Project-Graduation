<?php

namespace App\Repositories\Product;

use App\Models\Product;

class ProductRepository implements IProductRepository
{
    public function add($product){
        try{
            Product::create($product);
            return true;
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function update($product){
        if($this->existsById($product->id)){
            try{
                Product::where("id", $product->id)->update([
                    "name"=> $product->name,
                    "price"=> $product->price,
                    "description"=> $product->description,
                    "category_id"=> $product->category_id
                ]);
                return true;
            }
            catch(\Exception $e){
                throw new \Exception($e->getMessage());
            }
        }
        return false;
    }
    public function deleteById($id){
        try{
            Product::where("id",$id)->delete();
            return $this->existsById($id) === false;
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function getById($id){
        return Product::where("id", $id)->first();
    }
    public function existsById($id){
        return Product::where("id",$id)->exists();
    }
    public function getAll(){
        Product::all();
    }
}
