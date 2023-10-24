<?php

namespace App\Repositories;

use App\Models\WordsGroupsDetails;

class WordsGroupsDetailsRepo
{
    public function getAll()
    {
     
        $result = WordsGroupsDetails::all();   
    
        return $result;
    }
}