<?php

namespace App\Observers;

use App\Models\Articles;
use App\Exceptions\Custom;

class ArticlesObserver
{
    public function setDefault($articles){
        if ($articles->arti_order == null) {
            $articles->arti_order = 0;
        }
    }

    /**
     * Handle the articles "creating" event.
     *
     * @param  \App\Articles  $articles
     * @return void
    */
    public function creating(Articles $articles)
    {      
        if ($articles->cate_id != null && !$articles->categories) {
            throw new Custom\InvalidForeignKeyException();
        }

        $this->setDefault($articles);
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
            if ($articles->cate_id != null && !$articles->categories) {              
                throw new Custom\InvalidForeignKeyException();
            }
        }        
        $this->setDefault($articles);
    }
   
}
