<?php

namespace App\Observers\Validators;

use App\Repositories\WordsGroupsDetailsRepo;

class WordsGroupsDetailsValidator
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
