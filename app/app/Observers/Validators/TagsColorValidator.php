<?php

namespace App\Observers\Validators;

use App\Repositories\TagsColorRepo;

class TagsColorValidator
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
