<?php

namespace App\Services;

use App\Models\Cat;
use Illuminate\Http\Request;

class CatService
{
    public function createCat(array $data): Cat
    {
        $cat = Cat::create($data);

        return $cat;
    }

    public function updateCat(Cat $cat, array $data): Cat
    {
        $cat->update($data);

        return $cat;
    }
}
