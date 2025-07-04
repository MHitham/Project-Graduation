<?php

namespace App\Repositories\Fertilizer;

use App\Repositories\Icrud;

interface IFertilizerRepository extends Icrud
{
    public function getByNormalizedName($name);
    public function deleteByName($name);
    public function updateByName($fertilizer);
}
