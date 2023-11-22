<?php

namespace App\Validators\ModelValidators;

use App\Repositories\WordsGroupsDetailsRepo;

class WordsGroupsDetailsModelValidator
{    
    public function dupKey($data)
    {
        $WordsGroupsDetailsRepo = new WordsGroupsDetailsRepo();
        $row = $WordsGroupsDetailsRepo
                ->findByAssociatedIDs($data['ws_id'], $data['wg_id']);
        if($row != null){
            return false;
        }

        return true;
    }
}
