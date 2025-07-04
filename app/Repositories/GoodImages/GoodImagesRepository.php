<?php

namespace App\Repositories\GoodImages;

use App\Models\GoodImages;

class GoodImagesRepository implements IGoodImageRepository
{
    public function add($GoodImages){
        try{

            GoodImages::create($GoodImages);
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function existsById($id){
        return GoodImages::where("id", $id)->exists();
    }
    public function update($GoodImages){
        try{
            if($this->existsById($GoodImages->id)){
                GoodImages::where("id", $GoodImages->id)->update([
                    "good_id"=> $GoodImages->good_id,
                    "image_id"=> $GoodImages->image_id,
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
            GoodImages::where("id", $id)->delete();
            return $this->existsById($id) === false;
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function getById($id){
        return GoodImages::where("id", $id)->first();
    }
    public function getAll(){
        return GoodImages::all();
    }
}
