<?php

namespace App\Repositories;

use App\Models\WordsTags;

class WordsTagsRepo
{
    public function getAll()
    {
     
        $result = WordsTags::all();   
    
        return $result;
    }
}