<?php

namespace App\Repositories\Category;

use App\Repositories\Icrud;

interface ICategoryRepository extends Icrud
{
    public function isCategoryExistsByName($name);
    public function getByNormalizedName($name);
    public function updateByName($disease);
    public function deleteByName($name);
}
