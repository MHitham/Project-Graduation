<?php

namespace App\Repositories\PaymentMethod;

use App\Repositories\Icrud;

interface IPaymentMethodRepository extends Icrud
{
    public function getByNormalizedName($name);
    public function updateByName($disease);
    public function deleteByName($name);
    public function isExistsByName($name);
}
