<?php

namespace App\Repositories\Disease;

use App\Repositories\Icrud;

interface IDiseaseRepository extends Icrud
{
    public function getByNormalizedName($name);
    public function updateByName($disease);
    public function deleteByName($name);
    
}
