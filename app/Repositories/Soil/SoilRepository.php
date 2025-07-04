<?php

namespace App\Repositories\Soil;

use App\Models\Soil;

class SoilRepository implements ISoilRepository
{
    public function add($Soil){
        try{

            Soil::create([
                "name"=> $Soil->name,
                "normalized_name"=>strtoupper($Soil->name)
            ]);
            return $this->isSoilExistsByName($Soil->name);
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function existsById($id){
        return Soil::where("id", $id)->exists();
    }
    public function isSoilExistsByName($name){
        return Soil::where("normalized_name", strtoupper($name))->exists();
    }
    public function update($Soil){
        try{
            Soil::where("id", $Soil->id)->update([
                "name"=> $Soil->name,
                "normalized_name"=> strtoupper($Soil->name)
            ]);
            return $this->isSoilExistsByName($Soil->name);
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function updateByName($disease){
        try{
            Soil::where("normalized_name", strtoupper($disease->old_name))->update([
                "name"=> $disease->name,
                "description"=> $disease->description,
                "normalized_name"=> strtoupper($disease->name),
                "treatment"=>$disease->treatment
            ]);
            return $this->isSoilExistsByName($disease->name);
            
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function deleteByName($name){
        try{
            Soil::where("normalized_name", strtoupper($name))->delete();
            return $this->isSoilExistsByName($name) === false;
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function getByNormalizedName($name){
        return Soil::where("normalized_name", strtoupper($name))->first();
    }
    public function deleteById($id){
        try{
            Soil::where("id", $id)->delete();
            return $this->existsById($id) === false;
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function getById($id){
        return Soil::where("id", $id)->first();
    }
    public function getAll(){
        return Soil::all();
    }
}
