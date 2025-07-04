<?php

namespace App\Services\Image;

interface IImageService
{
    public function add($request);
    public function delete($request);
    public function get($request);
    public function getAll();
    public function update($request);
}
