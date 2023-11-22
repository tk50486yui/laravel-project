<?php

namespace App\Validators\ModelValidators;

use App\Repositories\WordsGroupsRepo;

class WordsGroupsModelValidator
{    
    public function dupName($wg_name, $id)
    {      
        $WordsGroupsRepo = new WordsGroupsRepo();
        $rowDup = $WordsGroupsRepo->findByName($wg_name);
        if ($rowDup == null) {
            return true;
        }
        if ($id === null) {
            return false;
        }
        $row = $WordsGroupsRepo->find($id);
        if ($row->wg_name == $rowDup['wg_name']) {
            return true;
        }

        return false;
    }   
}
