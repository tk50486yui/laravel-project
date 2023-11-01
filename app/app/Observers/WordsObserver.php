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

    /**
     * Handle the words "creating" event.
     *
     * @param  \App\Words  $words
     * @return void
    */
    public function creating(Words $words)
    {      
        if ($words->categories != null && !$words->categories) {
            throw new Custom\InvalidForeignKeyException();
        }
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
            if (!$words->categories) {
                throw new Custom\InvalidForeignKeyException();
            }
        }
        
    }

    public function setDefault($data)
    {
        $data['ws_is_important'] = is_bool($data['ws_is_important']) ? (bool)$data['ws_is_important'] : false;
        $data['ws_is_common'] = is_bool($data['ws_is_common']) ? (bool)$data['ws_is_common'] : false;
        $data['ws_forget_count'] = is_numeric($data['ws_forget_count']) ? (int)$data['ws_forget_count'] : 0;
        $data['ws_order'] = is_numeric($data['ws_order']) ? (int)$data['ws_order'] : 1;
        $data['cate_id'] = is_numeric($data['cate_id']) ? (int)$data['cate_id'] : null;

        return $data;
    }
}
