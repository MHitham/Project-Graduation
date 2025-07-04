<?php

namespace App\Repositories\Season;

use App\Models\Seasons;

class SeasonRepository implements ISeasonRepository
{
    public function add($season){
        try{

            Seasons::create([
                "name"=> $season->name,
                "normalized_name"=>strtoupper($season->name)
            ]);
            return $this->isSeasonsExistsByName($season->name);
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function getByNormalizedName($name){
        return Seasons::where("normalized_name", strtoupper($name))->first();
    }
    public function existsById($id){
        return Seasons::where("id", $id)->exists();
    }
    public function isSeasonsExistsByName($name){
        return Seasons::where("normalized_name", strtoupper($name))->exists();
    }
    public function update($Seasons){
        try{
            if($this->existsById($Seasons->id)){
                Seasons::where("id", $Seasons->id)->update([
                    "name"=> $Seasons->name,
                    "normalized_name"=> strtoupper($Seasons->name)
                ]);
                return $this->isSeasonsExistsByName($Seasons->name);
            }
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
        return false;
    }
    public function updateByName($season){
        try{
            Seasons::where("normalized_name", strtoupper($season->old_name))->update([
                "name"=> $season->name,
            ]);
            return $this->isSeasonExistsByName($season->name);
            
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function deleteByName($name){
        try{
            Seasons::where("normalized_name", strtoupper($name))->delete();
            return $this->isSeasonExistsByName($name) === false;
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function isSeasonExistsByName($name){
        return Seasons::where("normalized_name", strtoupper($name))->exists();
    }
    public function deleteById($id){
        try{
            Seasons::where("id", $id)->delete();
            return $this->existsById($id) === false;
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function getById($id){
        return Seasons::where("id", $id)->first();
    }
    public function getAll(){
        return Seasons::all();
    }
}
