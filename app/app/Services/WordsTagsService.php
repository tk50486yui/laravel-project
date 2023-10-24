<?php

namespace App\Services;

use App\Repositories\WordsTagsRepo;

class WordsTagsService
{
    public function getAll()
    {     
        $WordsTagsRepo = new WordsTagsRepo();
        $result = $WordsTagsRepo->getAll();   
    
        return $result;
    }
}