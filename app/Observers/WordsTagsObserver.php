<?php

namespace App\Observers;

use App\Models\WordsTags;
use App\Observers\Validators\WordsTagsValidator;
use App\Exceptions\Custom;

class WordsTagsObserver
{
    public function validate($data, $id){
        $WordsTagsValidator = new WordsTagsValidator();
        if (!$WordsTagsValidator->dupKey($data)) {
            throw new Custom\DuplicateException();
        }   
    }

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
