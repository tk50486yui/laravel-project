<?php

namespace App\Services;

use App\Repositories\WordsRepo;

class WordsService
{
    public function getAll()
    {     
        $WordsRepo = new WordsRepo();
        $result = $WordsRepo->getAll();   
    
        return $result;
    }
}