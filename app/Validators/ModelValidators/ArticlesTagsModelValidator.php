<?php

namespace App\Validators\ModelValidators;

use App\Repositories\ArticlesTagsRepo;

class ArticlesTagsModelValidator
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
