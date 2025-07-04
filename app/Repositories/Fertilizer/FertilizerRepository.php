<?php

namespace App\Repositories\Fertilizer;

use App\Models\Fertilizer;

class FertilizerRepository implements IFertilizerRepository
{
    public function add($fertilizer){
        try{

            Fertilizer::create([
                "name"=> $fertilizer->name,
                "description"=> $fertilizer->description,
                "normalized_name"=>strtoupper(strtoupper($fertilizer->name))
            ]);
            return $this->isFertilizerExistsByName($fertilizer->name);
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function existsById($id){
        return Fertilizer::where("id", $id)->exists();
    }
    public function isFertilizerExistsByName($name){
        return Fertilizer::where("normalized_name", strtoupper($name))->exists();
    }
    public function update($fertilizer){
        try{
            if($this->existsById($fertilizer->id)){
                Fertilizer::where("id", $fertilizer->id)->update([
                    "name"=> $fertilizer->name,
                    "description"=> $fertilizer->description,
                    "normalized_name"=> strtoupper($fertilizer->name)
                ]);
                return $this->isFertilizerExistsByName($fertilizer->name);
            }
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
        return false;
    }

    public function updateByName($fertilizer){
        try{
            Fertilizer::where("normalized_name", strtoupper($fertilizer->old_name))->update([
                "name"=> $fertilizer->name,
                "description"=> $fertilizer->description,
                "normalized_name"=> strtoupper($fertilizer->name)
            ]);
            return $this->isFertilizerExistsByName($fertilizer->name);
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function deleteById($id){
        try{
            Fertilizer::where("id", $id)->delete();
            return $this->existsById($id) === false;
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function getById($id){
        return Fertilizer::where("id", $id)->first();
    }

    public function getByNormalizedName($name){
        return Fertilizer::where("normalized_name", strtoupper($name))->first();
    }

    public function deleteByName($name){
        try{
            Fertilizer::where("normalized_name", strtoupper($name))->delete();
            return $this->isFertilizerExistsByName($name) === false;
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function getAll(){
        return Fertilizer::all();
    }
}
