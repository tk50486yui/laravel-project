<?php

namespace App\Validators;

use App\Validators\ModelValidators\ArticlesTagsModelValidator;
use App\Exceptions\Custom;

class ArticlesTagsValidator
{
    // add: $data, null **** update: $data, $id
    public function validate($data, $id){
        $ArticlesTagsModelValidator = new ArticlesTagsModelValidator();
        if (!$ArticlesTagsModelValidator->dupKey($data)) {
            throw new Custom\DuplicateException();
        }   
    }
}
