<?php

namespace App\Repositories;

interface Icrud
{
    public function getAll();
    public function existsById($id);
    public function getById($id);
    public function deleteById($id);
    public function add($object);
    public function update($object);
}
