<?php

namespace App\Observers;

use App\Models\Articles;
use App\Observers\Validators\ArticlesValidator;
use App\Exceptions\Custom;

class ArticlesObserver
{
    public function validate($data, $id, $checkDup = true)
    {
        $ArticlesValidator = new ArticlesValidator();
    }

    /**
     * Handle the articles "creating" event.
     *
     * @param  \App\Articles  $articles
     * @return void
    */
    public function creating(Articles $articles)
    {      
        if ($articles->categories != null && !$articles->categories) {
            throw new Custom\InvalidForeignKeyException();
        }
    }

    /**
     * Handle the articles "updating" event.
     *
     * @param  \App\Articles  $articles
     * @return void
    */
    public function updating(Articles $articles)
    {
        if ($articles->isDirty('cate_id')) {
            if (!$articles->categories) {
                throw new Custom\InvalidForeignKeyException();
            }
        }        
    }
   
}
