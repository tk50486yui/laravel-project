<?php

namespace App\Observers;

use App\Models\Categories;

class CategoriesObserver
{   
    public function setDefault($categories){
        if ($categories->cate_level == null) {
            $categories->cate_level = 1;
        }

        if ($categories->cate_order == null) {
            $categories->cate_order = 0;
        }
    }

    /**
     * Handle the categories "creating" event.
     *
     * @param  \App\Categories  $categories
     * @return void
    */
    public function creating(Categories $categories)
    {
        $this->setDefault($categories);
    }

    /**
     * Handle the categories "updating" event.
     *
     * @param  \App\Categories  $categories
     * @return void
    */
    public function updating(Categories $categories)
    {
        
    }   
}
