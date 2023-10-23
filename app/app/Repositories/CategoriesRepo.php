<?php

namespace App\Repositories;

use App\Models\Categories;

class CategoriesRepo
{
    public function getAll()
    {
     
        $result = Categories::all();   
    
        return $result;
    }
}