<?php

namespace App\Validators;

use App\Validators\ModelValidators\TagsModelValidator;
use App\Exceptions\Custom;

class TagsValidator
{
    // add: $data, null, true **** update: $data, $id, true
    public function validate($data, $id, $checkDup = true){
        $TagsModelValidator = new TagsModelValidator();
     
        if($id != null && !$TagsModelValidator->checkID($id)){
            throw new Custom\RecordNotFoundException();
        }
       
        if($checkDup && !$TagsModelValidator->dupName($data['ts_name'], $id)){
            throw new Custom\DuplicateException();
        }
        if(isset($data['ts_parent_id'])){
            if($data['ts_parent_id'] != null && !$TagsModelValidator->parentID($data['ts_parent_id'])){
                throw new Custom\InvalidForeignKeyException();
            }
          
            if($id != null && !$TagsModelValidator->validateTree($data['ts_parent_id'], $id)){
                throw new Custom\InvalidForeignKeyException();
            }
        }
    }
}
