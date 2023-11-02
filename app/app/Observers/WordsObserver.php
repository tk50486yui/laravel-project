<?php

namespace App\Observers;

use App\Models\Words;
use App\Observers\Validators\WordsValidator;
use App\Exceptions\Custom;

class WordsObserver
{
    public function validate($data, $id, $checkDup = true){
        $WordsValidator = new WordsValidator();
        if($id != null && !$WordsValidator->checkID($id)){
            throw new Custom\RecordNotFoundException();
        }
        if($checkDup && !$WordsValidator->dupName($data['ws_name'], $id)){
            throw new Custom\DuplicateException();
        }
    }

    public function setDefault($words){
        if ($words->ws_is_important == null) {
            $words->ws_is_important = false;
        }
        if ($words->ws_is_common == null) {
            $words->ws_is_common= false;
        }

        if ($words->ws_forget_count == null) {
            $words->ws_forget_count = 0;
        }
        if ($words->ws_order == null) {
            $words->ws_order= 0;
        }
    }

    /**
     * Handle the words "creating" event.
     *
     * @param  \App\Words  $words
     * @return void
    */
    public function creating(Words $words)
    {      
        if ($words->cate_id != null && !$words->categories) {
            throw new Custom\InvalidForeignKeyException();
        }

        $this->setDefault($words);
    }

    /**
     * Handle the words "updating" event.
     *
     * @param  \App\Words  $words
     * @return void
    */
    public function updating(Words $words)
    {
        if ($words->isDirty('cate_id')) {
            if ($words->cate_id != null && !$words->categories) {
                throw new Custom\InvalidForeignKeyException();
            }
        }
        
        $this->setDefault($words);
    }
}
