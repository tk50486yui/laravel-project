<?php

namespace App\Repositories;

use App\Models\Tags;

class TagsRepo
{
    public function getAll()
    {
     
        $result = Tags::all();
    
        return $result;
    }   

    public function findAll()
    {     
        $result = Tags::orderBy('ts_order', 'ASC')->get();       

        return $result;          
    } 
}