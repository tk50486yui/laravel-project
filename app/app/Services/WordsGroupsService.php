<?php

namespace App\Services;

use App\Repositories\WordsGroupsRepo;
use App\Repositories\WordsGroupsDetailsRepo;

class WordsGroupsService
{
    public function getAll()
    {     
        $WordsGroupsRepo = new WordsGroupsRepo();
        $result = $WordsGroupsRepo->getAll();   
    
        return $result;
    }

    public function find($id)
    {        
        $WordsGroupsDetailsRepo = new WordsGroupsDetailsRepo();
        $result =  $WordsGroupsDetailsRepo->findByWgID($id);      

        return $result;
    }

    public function findAll()
    {
        $WordsGroupsRepo = new WordsGroupsRepo();
        $WordsGroupsDetailsRepo = new WordsGroupsDetailsRepo();
        $result = $WordsGroupsRepo->findAll();
        $i=0;
        if(count($result) > 0){
            foreach($result as $item){
                $result[$i]['details'] = $WordsGroupsDetailsRepo->findByWgID($item->id);
                $i++;
            }
        }

        return $result;
    }
}