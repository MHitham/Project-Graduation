<?php

namespace App\Services\Product;

interface IProductService
{
    public function add($request);
    public function delete($request);
    public function get($request);
    public function getAll();
    public function update($request);
}
