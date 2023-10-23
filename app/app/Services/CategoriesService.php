<?php

namespace App\Services;

use App\Repositories\CategoriesRepo;

class CategoriesService
{
    public function getAll()
    {     
        $CategoriesRepo = new CategoriesRepo();
        $result = $CategoriesRepo->getAll();   
    
        return $result;
    }
}