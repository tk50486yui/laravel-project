<?php

namespace App\Validators;

use App\Validators\ModelValidators\CategoriesModelValidator;
use App\Exceptions\Custom;

class CategoriesValidator
{
    // add: $data, null, true **** update: $data, $id, true
    public function validate($data, $id, $checkDup = true){
        $CategoriesModelValidator = new CategoriesModelValidator();
        if($id != null && !$CategoriesModelValidator->checkID($id)){
            throw new Custom\RecordNotFoundException();
        }
        if($checkDup && !$CategoriesModelValidator->dupName($data['cate_name'], $id)){
            throw new Custom\DuplicateException();
        }
        if(isset($data['cate_parent_id'])){
            if($data['cate_parent_id'] != null && !$CategoriesModelValidator->parentID($data['cate_parent_id'])){
                throw new Custom\InvalidForeignKeyException();
            }
    
            if($id != null && !$CategoriesModelValidator->validateTree($data['cate_parent_id'], $id)){
                throw new Custom\InvalidForeignKeyException();
            }
        }
    }
}
