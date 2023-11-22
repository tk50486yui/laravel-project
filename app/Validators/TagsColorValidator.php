<?php

namespace App\Validators;

use App\Validators\ModelValidators\TagsColorModelValidator;
use App\Exceptions\Custom;

class TagsColorValidator
{
    // add: $data, null, true **** update: $data, $id, true
    public function validate($data, $id){
        $TagsColorModelValidator = new TagsColorModelValidator();
     
        if($id != null && !$TagsColorModelValidator->checkID($id)){
            throw new Custom\RecordNotFoundException();
        }
       
    }
  
}
