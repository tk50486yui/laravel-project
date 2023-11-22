<?php

namespace App\Validators;

use App\Validators\ModelValidators\ArticlesModelValidator;
use App\Exceptions\Custom;

class ArticlesValidator
{
    // add: $data, null, true **** update: $data, $id, true
    public function validate($data, $id, $checkDup = true)
    {
        $ArticlesModelValidator = new ArticlesModelValidator();
        if($id != null && !$ArticlesModelValidator->checkID($id)){
            throw new Custom\RecordNotFoundException();
        }
    }
}
