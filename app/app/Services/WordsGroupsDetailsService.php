<?php

namespace App\Services;

use App\Repositories\WordsGroupsDetailsRepo;

class WordsGroupsDetailsService
{
    public function getAll()
    {     
        $WordsGroupsDetailsRepo = new WordsGroupsDetailsRepo();
        $result = $WordsGroupsDetailsRepo->getAll();   
    
        return $result;
    }
}