<?php

namespace App\Repositories\Images;

use App\Models\Images;

class ImageRepository implements IImageReposiroty
{
    public function add($Image){
        try{
            $Image::create([
                "url"=> $Image->url,
            ]);
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function existsById($id){
        return Images::where("id", $id)->exists();
    }
    public function update($Image){
        try{
            if($this->existsById($Image->id)){
                Images::where("id", $Image->id)->update([
                    "url"=> $Image->url,
                ]);
            }
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
        return false;
    }
    public function deleteById($id){
        try{
            Images::where("id", $id)->delete();
            return $this->existsById($id) === false;
        }
        catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    public function getById($id){
        return Images::where("id", $id)->first();
    }
    public function getAll(){
        return Images::all();
    }
}
