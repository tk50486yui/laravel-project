<?php

namespace App\Observers;

use App\Models\WordsGroups;
use App\Observers\Validators\WordsGroupsValidator;
use App\Exceptions\Custom;

class WordsGroupsObserver
{
    public function validate($data, $id, $checkDup = true){
        $WordsGroupsValidator = new WordsGroupsValidator();
        if($checkDup && !$WordsGroupsValidator->dupName($data['wg_name'], $id)){
            throw new Custom\DuplicateException();
        }
    }   

    /**
     * Handle the WordsGroups "creating" event.
     *
     * @param  \App\WordsGroups  $wordsGroups
     * @return void
    */
    public function creating(WordsGroups $wordsGroups)
    {

    }

    /**
     * Handle the WordsGroups "updating" event.
     *
     * @param  \App\WordsGroups  $wordsGroups
     * @return void
    */
    public function updating(WordsGroups $wordsGroups)
    {
      
    }
}
