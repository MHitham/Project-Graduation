<?php

namespace App\Services\Fertilizer;

interface IFertilizerService
{
    public function add($request);
    public function update($request);
    public function delete($request);
    public function get($request);
    public function getAll();

}
