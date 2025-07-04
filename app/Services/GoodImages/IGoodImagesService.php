<?php

namespace App\Services\GoodImages;

interface IGoodImagesService
{
    public function add($request);
    public function update($request);
    public function delete($request);
    public function get($request);
    public function getAll();
}
