<?php

namespace App\Validators;

use App\Validators\ModelValidators\WordsGroupsDetailsModelValidator;
use App\Exceptions\Custom;

class WordsGroupsDetailsValidator
{    
    // add: $data, null **** update: $data, $id
    public function validate($data, $id){
        $WordsGroupsDetailsModelValidator = new WordsGroupsDetailsModelValidator();
        if(!$WordsGroupsDetailsModelValidator->dupKey($data)){
            throw new Custom\DuplicateException();
        }
    } 
}
