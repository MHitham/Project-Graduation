<?php

namespace App\Repositories\Category;

use App\Models\Category;

class CategoryRepository implements ICategoryRepository
{
    
    public function add($category){
        try{
            Category::create([
                "name"=> $category->name,
                "normalized_name"=>strtoupper($category->name)
            ]);
            return $this->isCategoryExistsByName($category->name);
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function existsById($id){
        return Category::where("id", $id)->exists();
    }
    public function isCategoryExistsByName($name){
        return Category::where("normalized_name", strtoupper($name))->exists();
    }
    public function update($category){
        try{
            if($this->existsById($category->id)){
                Category::where("id", $category->id)->update([
                    "name"=> $category->name,
                    "normalized_name"=> strtoupper($category->name)
                ]);
                return $this->isCategoryExistsByName($category->name);
            }
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
        return false;
    }
    public function deleteById($id){
        try{
            Category::where("id", $id)->delete();
            return $this->existsById($id) === false;
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function getById($id){
        return Category::where("id", $id)->first();
    }
    public function getAll(){
        return Category::all();
    }
    public function updateByName($disease){
        try{
            Category::where("normalized_name", strtoupper($disease->old_name))->update([
                "name"=> $disease->name,
                "normalized_name"=> strtoupper($disease->name),
            ]);
            return $this->isCategoryExistsByName($disease->name);
            
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function deleteByName($name){
        try{
            Category::where("normalized_name", strtoupper($name))->delete();
            return $this->isCategoryExistsByName($name) === false;
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function getByNormalizedName($name){
        return Category::where("normalized_name", strtoupper($name))->first();
    }
}
