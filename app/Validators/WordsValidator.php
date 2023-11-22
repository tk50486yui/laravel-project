<?php

namespace App\Validators;

use App\Validators\ModelValidators\WordsModelValidator;
use App\Exceptions\Custom;

class WordsValidator
{
    // add: $data, null, true **** update: $data, $id, true
    public function validate($data, $id, $checkDup = true){
        $WordsModelValidator = new WordsModelValidator();
        if($id != null && !$WordsModelValidator->checkID($id)){
            throw new Custom\RecordNotFoundException();
        }
        if($checkDup && !$WordsModelValidator->dupName($data['ws_name'], $id)){
            throw new Custom\DuplicateException();
        }
    }
}
