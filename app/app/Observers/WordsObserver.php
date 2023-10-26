<?php

namespace App\Observers;

use App\Models\Words;
use Illuminate\Validation\ValidationException;

class WordsObserver
{
    /**
     * Handle the words "created" event.
     *
     * @param  \App\Words  $words
     * @return void
     */
    public function created(Words $words)
    {
        //
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
            throw new ValidationException('fk');
        }
    }

    /**
     * Handle the words "updated" event.
     *
     * @param  \App\Words  $words
     * @return void
     */
    public function updated(Words $words)
    {
        //
    }

    /**
     * Handle the words "deleted" event.
     *
     * @param  \App\Words  $words
     * @return void
     */
    public function deleted(Words $words)
    {
        //
    }

    /**
     * Handle the words "restored" event.
     *
     * @param  \App\Words  $words
     * @return void
     */
    public function restored(Words $words)
    {
        //
    }

    /**
     * Handle the words "force deleted" event.
     *
     * @param  \App\Words  $words
     * @return void
     */
    public function forceDeleted(Words $words)
    {
        //
    }
}
