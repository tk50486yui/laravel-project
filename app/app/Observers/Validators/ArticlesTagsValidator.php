<?php

namespace App\Observers\Validators;

use App\Repositories\ArticlesTagsRepo;

class ArticlesTagsValidator
{
    public function dupKey($data)
    {
        $ArticlesTagsRepo = new ArticlesTagsRepo();
        $row = $ArticlesTagsRepo
                ->findByAssociatedIDs($data['arti_id'], $data['ts_id']);
        if($row != null){
            return false;
        }

        return true;
    }
}
