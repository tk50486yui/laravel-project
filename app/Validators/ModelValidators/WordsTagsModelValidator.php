<?php

namespace App\Validators\ModelValidators;

use App\Repositories\WordsTagsRepo;

class WordsTagsModelValidator
{
    public function dupKey($data)
    {
        $WordsTagsRepo = new WordsTagsRepo();
        $row = $WordsTagsRepo
                ->findByAssociatedIDs($data['ws_id'], $data['ts_id']);
        if($row != null){
            return false;
        }

        return true;
    }
}
