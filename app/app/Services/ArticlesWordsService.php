<?php

namespace App\Services;

use App\Repositories\ArticlesWordsRepo;

class ArticlesWordsService
{
    public function getAll()
    {     
        $ArticlesWordsRepo = new ArticlesWordsRepo();
        $result = $ArticlesWordsRepo->getAll();   
    
        return $result;
    }
}