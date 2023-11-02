<?php

namespace App\Observers\Validators;

use App\Repositories\WordsTagsRepo;

class WordsTagsValidator
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
