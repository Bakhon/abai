<?php

namespace App\Repositories\Interfaces;

interface WellRepositoryInterface
{
    public function wellItems(int $id,?int $period) :?array;
    public function collectData(object $data) :array;
}