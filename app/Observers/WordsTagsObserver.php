<?php

namespace App\Observers;

use App\Models\WordsTags;
use App\Exceptions\Custom;

class WordsTagsObserver
{
     /**
     * Handle the wordsTags "creating" event.
     *
     * @param  \App\wordsTags  $wordsTags
     * @return void
    */
    public function creating(WordsTags $wordsTags)
    {      
        if (!$wordsTags->tags) {
            throw new Custom\InvalidForeignKeyException();
        }
    }
    
}
