<?php

namespace App\Observers;

use App\Models\WordsGroupsDetails;
use App\Exceptions\Custom;

class WordsGroupsDetailsObserver
{
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
