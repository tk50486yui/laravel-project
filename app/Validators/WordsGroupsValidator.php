<?php

namespace App\Validators;

use App\Validators\ModelValidators\WordsGroupsModelValidator;
use App\Exceptions\Custom;

class WordsGroupsValidator
{    
    // add: $data, null, true **** update: $data, $id, true
    public function validate($data, $id, $checkDup = true){
        $WordsGroupsModelValidator = new WordsGroupsModelValidator();
        if($checkDup && !$WordsGroupsModelValidator->dupName($data['wg_name'], $id)){
            throw new Custom\DuplicateException();
        }
    }
}
