<?php

namespace App\Observers;

use App\Models\ArticlesTags;
use App\Exceptions\Custom;

class ArticlesTagsObserver
{
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
