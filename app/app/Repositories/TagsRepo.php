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

    public function find($id)
    {     
        $result = Tags::where('id', $id)->first();

        return $result;          
    }

    public function findAll()
    {     
        $result = Tags::orderBy('ts_order', 'ASC')->get();       

        return $result;          
    } 

    public function findRecent()
    {     
        $result = Tags::orderBy('created_at', 'DESC')
                    ->orderBy('updated_at', 'DESC')
                    ->get();

        return $result;
    }
    
}