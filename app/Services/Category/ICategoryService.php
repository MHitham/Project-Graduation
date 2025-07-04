<?php

namespace App\Services\Category;

interface ICategoryService
{
    public function add($request);
    public function update($request);
    public function delete($request);
    public function get($request);
    public function getAll();
}
