<?php

namespace App\Repositories;

use App\Models\WordsGroups;

class WordsGroupsRepo
{
    public function getAll()
    {     
        return WordsGroups::all();
    }

    public function findAll()
    {
        return  WordsGroups::orderBy('created_at', 'DESC')->get();
    }

    public function add($data)
    {
      
    }

    public function edit($data, $id)
    {
      
    }
}