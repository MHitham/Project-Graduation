<?php

namespace App\Services\Season;

interface ISeasonService
{
    public function add($request);
    public function update($request);
    public function delete($request);
    public function get($request);
    public function getAll();
}
