<?php

namespace App\Services;

use App\Repositories\ArticlesTagsRepo;

class ArticlesTagsService
{
    public function getAll()
    {     
        $ArticlesTagsRepo = new ArticlesTagsRepo();
        $result = $ArticlesTagsRepo->getAll();   
    
        return $result;
    }
}