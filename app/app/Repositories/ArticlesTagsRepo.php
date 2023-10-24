<?php

namespace App\Repositories;

use App\Models\ArticlesTags;

class ArticlesTagsRepo
{
    public function getAll()
    {
     
        $result = ArticlesTags::all();   
    
        return $result;
    }
}