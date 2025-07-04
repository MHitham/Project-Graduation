<?php

namespace App\Services\Soil;

interface ISoilService
{
    public function add($request);
    public function update($request);
    public function delete($request);
    public function get($request);
    public function getAll();
}
