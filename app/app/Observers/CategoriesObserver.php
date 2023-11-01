<?php

namespace App\Observers;

use App\Models\Categories;
use App\Observers\Validators\CategoriesValidator;
use App\Exceptions\Custom;

class CategoriesObserver
{
    public function validate($data, $id, $checkDup = true){
        $CategoriesValidator = new CategoriesValidator();
        if($id != null && !$CategoriesValidator->checkID($id)){
            throw new Custom\RecordNotFoundException();
        }
        if($checkDup && !$CategoriesValidator->dupName($data['cate_name'], $id)){
            throw new Custom\DuplicateException();
        }
        if($data['cate_parent_id'] != null && !$CategoriesValidator->parentID($data['cate_parent_id'])){
            throw new Custom\InvalidForeignKeyException();
        }

        if($id != null && !$CategoriesValidator->validateTree($data['cate_parent_id'], $id)){
            throw new Custom\InvalidForeignKeyException();
        }
    }

    /**
     * Handle the categories "creating" event.
     *
     * @param  \App\Categories  $categories
     * @return void
    */
    public function creating(Categories $categories)
    {      
        if ($categories->cate_level == null) {
            $categories->cate_level = 1;
        }

        if ($categories->cate_order == null) {
            $categories->cate_order = 0;
        }
    }

    /**
     * Handle the categories "updating" event.
     *
     * @param  \App\Categories  $categories
     * @return void
    */
    public function updating(Categories $categories)
    {
        
        
    }   
}
