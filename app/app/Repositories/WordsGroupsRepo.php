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

    public function findAll()
    {
        $result = WordsGroups::orderBy('created_at', 'DESC')->get();;
      
        return $result;
    }
}