<?php

namespace App\Validators\ModelValidators;

use App\Repositories\TagsColorRepo;

class TagsColorModelValidator
{
    public function checkID($id)
    {      
        $TagsColorRepo = new TagsColorRepo();
        $result = $TagsColorRepo->find($id); 
        if(!$result){
            return false;
        }
        return true;
    }
  
}
