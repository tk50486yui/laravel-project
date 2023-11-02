<?php

namespace App\Observers;

use App\Models\ArticlesTags;
use App\Observers\Validators\ArticlesTagsValidator;
use App\Exceptions\Custom;

class ArticlesTagsObserver
{
    public function validate($data, $id){
        $ArticlesTagsValidator = new ArticlesTagsValidator();
        if (!$ArticlesTagsValidator->dupKey($data)) {
            throw new Custom\DuplicateException();
        }   
    }

     /**
     * Handle the wordsTags "creating" event.
     *
     * @param  \App\ArticlesTags  $articlesTags
     * @return void
    */
    public function creating(ArticlesTags $articlesTags)
    {      
        if (!$articlesTags->tags) {
            throw new Custom\InvalidForeignKeyException();
        }
    }
    
}
