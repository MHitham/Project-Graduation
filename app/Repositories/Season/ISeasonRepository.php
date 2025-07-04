<?php

namespace App\Repositories\Season;

use App\Repositories\Icrud;

interface ISeasonRepository extends Icrud
{
    public function getByNormalizedName($name);
    public function updateByName($disease);
    public function deleteByName($name);
    public function isSeasonExistsByName($name);
}
