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

    public function findAll(){
      

        $result = Categories::orderBy('cate_order', 'ASC')->get();       

        return $result;
    }
}