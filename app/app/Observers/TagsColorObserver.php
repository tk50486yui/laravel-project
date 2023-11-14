<?php

namespace App\Observers;

use App\Observers\Validators\TagsColorValidator;
use App\Exceptions\Custom;

class TagsColorObserver
{
    public function validate($data, $id){
        $TagsColorValidator = new TagsColorValidator();
     
        if($id != null && !$TagsColorValidator->checkID($id)){
            throw new Custom\RecordNotFoundException();
        }
       
    }   
   
}
