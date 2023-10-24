<?php

namespace App\Repositories;

use App\Models\ArticlesWords;

class ArticlesWordsRepo
{
    public function getAll()
    {
     
        $result = ArticlesWords::all();   
    
        return $result;
    }
}