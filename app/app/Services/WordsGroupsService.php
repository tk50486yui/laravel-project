<?php

namespace App\Services;

use App\Repositories\WordsGroupsRepo;

class WordsGroupsService
{
    public function getAll()
    {     
        $WordsGroupsRepo = new WordsGroupsRepo();
        $result = $WordsGroupsRepo->getAll();   
    
        return $result;
    }
}