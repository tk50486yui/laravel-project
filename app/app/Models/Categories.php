<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    public function getAll()
    {
     
        $categories = Categories::all();   
    
        return $categories;
    }
}
