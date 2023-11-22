<?php

namespace App\Validators;

use App\Validators\ModelValidators\WordsTagsModelValidator;
use App\Exceptions\Custom;

class WordsTagsValidator
{
    // add: $data, null **** update: $data, $id
    public function validate($data, $id){
        $WordsTagsModelValidator = new WordsTagsModelValidator();
        if (!$WordsTagsModelValidator->dupKey($data)) {
            throw new Custom\DuplicateException();
        }   
    }
}
