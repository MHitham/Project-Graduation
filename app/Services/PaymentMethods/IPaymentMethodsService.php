<?php

namespace App\Services\PaymentMethods;

interface IPaymentMethodsService
{
    public function add($request);
    public function delete($request);
    public function get($request);
    public function getAll();
    public function update($request);
}
