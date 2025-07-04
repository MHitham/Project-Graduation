<?php

namespace App\Repositories\Soil;

use App\Repositories\Icrud;

interface ISoilRepository extends Icrud
{
    public function getByNormalizedName($name);
    public function updateByName($disease);
    public function deleteByName($name);
    public function isSoilExistsByName($name);
}
