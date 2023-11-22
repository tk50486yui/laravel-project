<?php

namespace App\Validators\ModelValidators;

use App\Repositories\ArticlesRepo;

class ArticlesModelValidator
{
    public function checkID($id)
    {      
        $ArticlesRepo = new ArticlesRepo();
        $result = $ArticlesRepo->find($id); 
        if(!$result){
            return false;
        }
        return true;
    }
}
