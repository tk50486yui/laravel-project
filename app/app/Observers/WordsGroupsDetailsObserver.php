<?php

namespace App\Observers;

use App\Models\WordsGroupsDetails;
use App\Observers\Validators\WordsGroupsDetailsValidator;
use App\Exceptions\Custom;

class WordsGroupsDetailsObserver
{
    public function validate($data, $id){
        $WordsGroupsDetailsValidator = new WordsGroupsDetailsValidator();
        if(!$WordsGroupsDetailsValidator->dupKey($data)){
            throw new Custom\DuplicateException();
        }
    }   

    /**
     * Handle the WordsGroupsDetails "creating" event.
     *
     * @param  \App\WordsGroupsDetails  $wordsGroupsDetails
     * @return void
    */
    public function creating(WordsGroupsDetails $wordsGroupsDetails)
    {
        if (!$wordsGroupsDetails->words) {
            throw new Custom\InvalidForeignKeyException();
        }
    }   
}
