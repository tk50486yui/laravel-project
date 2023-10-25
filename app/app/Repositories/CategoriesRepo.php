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

    public function find($id)
    {
        $result = Categories::where('id', $id)->first();

        return $result;
    }

    public function findAll()
    {
        $result = Categories::orderBy('cate_order', 'ASC')->get(); 
        
        return $result;
    }

    public function findRecent()
    {     
        $result = Categories::orderBy('created_at', 'DESC')
                    ->orderBy('updated_at', 'DESC')
                    ->get();
                    
        return $result;          
    }
}