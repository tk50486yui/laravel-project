<?php

namespace App\Repositories;

use App\Models\Words;

class WordsRepo
{
    public function getAll()
    {
     
        $result = Words::all();   
    
        return $result;
    }
}