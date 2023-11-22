<?php

namespace App\Observers;

use App\Models\Tags;
use App\Exceptions\Custom;

class TagsObserver
{ 
    public function setDefault($tags){
        if ($tags->ts_storage == null) {
            $tags->ts_storage = true;
        }

        if ($tags->ts_level == null) {
            $tags->ts_level = 1;
        }

        if ($tags->ts_order == null) {
            $tags->ts_order = 0;
        }
    }

    /**
     * Handle the tags "creating" event.
     *
     * @param  \App\Tags  $tags
     * @return void
    */
    public function creating(Tags $tags)
    {    
        if ($tags->tc_id != null && !$tags->tagsColor) {
            throw new Custom\InvalidForeignKeyException();
        }
        $this->setDefault($tags);
    }

    /**
     * Handle the tags "updating" event.
     *
     * @param  \App\Tags  $tags
     * @return void
    */
    public function updating(Tags $tags)
    {
        if ($tags->isDirty('tc_id')) {
            if ($tags->tc_id != null && !$tags->tagsColor) {
                throw new Custom\InvalidForeignKeyException();
            }
        }       
    }   
}
