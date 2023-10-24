<?php

namespace App\Repositories;

use App\Models\WordsGroups;

class WordsGroupsRepo
{
    public function getAll()
    {
     
        $result = WordsGroups::all();   
    
        return $result;
    }
}