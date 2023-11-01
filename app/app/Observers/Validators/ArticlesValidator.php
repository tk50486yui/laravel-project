<?php

namespace App\Observers\Validators;

use App\Repositories\ArticlesRepo;

class ArticlesValidator
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
