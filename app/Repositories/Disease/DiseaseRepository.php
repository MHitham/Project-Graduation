<?php

namespace App\Repositories\Disease;

use App\Models\Disease;

class DiseaseRepository implements IDiseaseRepository
{
    public function add($Disease){
        try{

            Disease::create([
                "name"=> $Disease->name,
                "description"=> $Disease->description,
                "treatment"=> $Disease->treatment,
                "normalized_name"=>strtoupper($Disease->name)
            ]);
            return $this->isExistsByName($Disease->name);
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function existsById($id){
        return Disease::where("id", $id)->exists();
    }
    public function isExistsByName($name){
        return Disease::where("normalized_name", strtoupper($name))->exists();
    }
    public function update($Disease){
        try{
            Disease::where("id", $Disease->id)->update([
                "name"=> $Disease->name,
                "description"=> $Disease->description,
                "treatment"=> $Disease->description,
                "normalized_name"=> strtoupper($Disease->name)
            ]);
            return $this->isExistsByName($Disease->name);
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function updateByName($disease){
        try{
            Disease::where("normalized_name", strtoupper($disease->old_name))->update([
                "name"=> $disease->name,
                "description"=> $disease->description,
                "normalized_name"=> strtoupper($disease->name),
                "treatment"=>$disease->treatment
            ]);
            return $this->isExistsByName($disease->name);
            
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function deleteById($id){
        try{
            Disease::where("id", $id)->delete();
            return $this->existsById($id) === false;
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function deleteByName($name){
        try{
            Disease::where("normalized_name", strtoupper($name))->delete();
            return $this->isExistsByName($name) === false;
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function getById($id){
        return Disease::where("id", $id)->first();
    }
    public function getByNormalizedName($name){
        return Disease::where("normalized_name", strtoupper($name))->first();
    }
    public function getAll(){
        return Disease::all();
    }
}
