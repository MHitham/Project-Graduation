<?php

namespace App\Services\Cart;

interface ICartService
{
    public function add($request);
    public function delete($request);
    public function get($request);
    public function getAll();
    public function update($request);
}
