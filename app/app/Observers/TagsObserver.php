<?php

namespace App\Observers;

use App\Models\Tags;
use App\Observers\Validators\TagsValidator;
use App\Exceptions\Custom;

class TagsObserver
{
    public function validate($data, $id, $checkDup = true){
        $TagsValidator = new TagsValidator();
     
        if($id != null && !$TagsValidator->checkID($id)){
            throw new Custom\RecordNotFoundException();
        }
       
        if($checkDup && !$TagsValidator->dupName($data['ts_name'], $id)){
            throw new Custom\DuplicateException();
        }
     
        if($data['ts_parent_id'] != null && !$TagsValidator->parentID($data['ts_parent_id'])){
            throw new Custom\InvalidForeignKeyException();
        }
      
        if($id != null && !$TagsValidator->validateTree($data['ts_parent_id'], $id)){
            throw new Custom\InvalidForeignKeyException();
        }     
       
    }

    /**
     * Handle the tags "creating" event.
     *
     * @param  \App\Tags  $tags
     * @return void
    */
    public function creating(Tags $tags)
    {    
        if ($tags->ts_storage == null) {
            $tags->ts_storage = true;
        }

        if ($tags->ts_level == null) {
            $tags->ts_level = 1;
        }

        if ($tags->ts_order == null) {
            $tags->ts_order = 0;
        }
    }

    /**
     * Handle the tags "updating" event.
     *
     * @param  \App\Tags  $tags
     * @return void
    */
    public function updating(Tags $tags)
    {
        
        
    }   
}
